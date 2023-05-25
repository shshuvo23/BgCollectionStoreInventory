<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Models\CalenderStatus;
use App\Models\ExportCalender;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderManagementController extends Controller
{
    private function getCalender()
    {
        return ExportCalender::join('buyers', 'buyers.id', '=', 'export_calenders.buyer_id')
            ->leftJoin('calender_statuses', 'calender_statuses.id', '=', 'export_calenders.status_id')
            ->whereNot('export_calenders.status_id', 1)
            ->orWhere('export_calenders.status_id', null)
            ->select('export_calenders.id', 'export_calenders.job_no', 'export_calenders.merchandiser', 'export_calenders.fabrication', 'export_calenders.order_no', 'export_calenders.order_qty', 'export_calenders.unit_price', 'export_calenders.total', 'buyers.buyer_name', 'calender_statuses.status', 'export_calenders.month')
            ->orderBy('export_calenders.month', 'asc')
            // ->orderBy('export_calenders.job_no', 'asc')
            ->orderBy('export_calenders.id', 'asc')
            ->get();
    }
    public function orders()
    {
        $orders = $this->getCalender();
        $checkSMR = '';
        if (auth()->user()->role_id == 6) {
            $checkSMR = 1;
        } else {
            $checkSMR = 0;
        }

        return response()->json([
            'checkMr' => $checkSMR,
            'orders' => $orders,
        ]);
    }
    public function index()
    {
        $orders = ExportCalender::get();
        return view('order_management.index', [
            'page_title' => 'Export Calendar Management',
            'page_message' => 'Manage order ',
            'orders' => $orders
        ]);
    }

    public function addOrder()
    {
        return view('order_management.addOrder', [
            'page_title' => 'Add Export Order',
            'page_message' => 'Add order on export calendar',
        ]);
    }

    public function createOrder(Request $request)
    {
        $data = $request->all();
        $dataRules = [
            'selectedMonth' => ['required'],
            'buyer' => ['required'],
            'merchandiser' => ['required'],
            'fabrication' => ['required'],
            'order_no' => ['required'],
            'order_qty' => ['required', 'integer'],
            'unit_price' => ['required', 'numeric'],
        ];

        $validator = Validator::make($data, $dataRules);

        if ($validator->fails()) {
            return response()->json([
                'isError' => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            $buyer = Buyer::where('id', $request->buyer)->first();
            $buyer_id = "";
            if ($buyer) {
                $buyer_id = $buyer->id;
            } else {
                $buyer = new Buyer;
                $buyer->buyer_name = $request->buyer;
                $buyer->created_by = auth()->user()->id;
                $buyer->save();
                $buyer_id = $buyer->id;
            }

            $status_id = null;

            if ($request->status !== null) {
                $status = CalenderStatus::where('id', $request->status)->first();
                $status_id = "";
                if ($status) {
                    $status_id = $status->id;
                } else {
                    $status = new CalenderStatus;
                    $status->status = $request->status;
                    $status->save();
                    $status_id = $status->id;
                }
            }
            //return strtotime($request->selectedMonth);
            //return $strTin = date_format($request->selectedMonth,"m-YYYY");


            $Month = date("Y-m", strtotime($request->selectedMonth));
            $Month .= '-01';
            $job = date("M", strtotime($Month));

            $items = ExportCalender::where('month', $Month)->pluck('job_no');

            $maxJob = 0;
            foreach ($items as $item) {
                $jobNo = (explode("-", $item))[count(explode("-", $item)) - 1];
                $jobNo = (int)$jobNo;
                if ($maxJob < $jobNo) $maxJob = $jobNo;
            }


            $job .= '-' . ++$maxJob;

            // return $job;
            $orderManagement = new ExportCalender;
            $orderManagement->month = $Month;
            $orderManagement->job_no = $job;
            $orderManagement->buyer_id = $buyer_id;
            $orderManagement->merchandiser = $request->merchandiser;
            $orderManagement->fabrication = $request->fabrication;
            $orderManagement->order_no = $request->order_no;
            $orderManagement->order_qty = $request->order_qty;
            $orderManagement->unit_price = $request->unit_price;
            $orderManagement->total = $request->total;
            $orderManagement->status_id = $status_id;
            $orderManagement->save();
            return response()->json([
                'oldData' => $data,
                'success' => true,
                'message' => 'Order added on calender'
            ]);
        }
    }

    public function editOrder(Request $request)
    {
        $id = $request->id;
        $orders = ExportCalender::join('buyers', 'buyers.id', '=', 'export_calenders.buyer_id')
            ->leftJoin('calender_statuses', 'calender_statuses.id', '=', 'export_calenders.status_id')
            ->where('export_calenders.id', $id)
            ->select('export_calenders.id', 'export_calenders.job_no', 'export_calenders.merchandiser', 'export_calenders.fabrication', 'export_calenders.order_no', 'export_calenders.order_qty', 'export_calenders.unit_price', 'export_calenders.total', 'buyers.buyer_name', 'buyers.id as buyerId', 'calender_statuses.status', 'export_calenders.month')
            ->first();

        return response()->json([
            'order' => $orders
        ]);
    }

    public function updateOrder(Request $request)
    {
        $id = $request->params['id'];
        $data = $request->params['data'];
        $dataRules = [
            'selectedMonth' => ['required', 'date'],
            'buyer' => ['required'],
            'merchandiser' => ['required'],
            'fabrication' => ['required'],
            'order_no' => ['required'],
            'order_qty' => ['required', 'integer'],
            'unit_price' => ['required', 'numeric'],
        ];

        $validator = Validator::make($data, $dataRules);


        if ($validator->fails()) {
            return response()->json([
                'isError' => true,
                'errors' => $validator->errors(),
            ]);
        } else {

            $buyer = Buyer::where('id', $data['buyer'])->first();
            $buyer_id = "";
            if ($buyer) {
                $buyer_id = $buyer->id;
            } else {
                $buyer = new Buyer;
                $buyer->buyer_name =  $data['buyer'];
                $buyer->created_by = auth()->user()->id;
                $buyer->save();
                $buyer_id = $buyer->id;
            }
            $status_id = null;
            if ($data['status'] !== null) {
                $status = CalenderStatus::where('id', $data['status'])->first();
                $status_id = "";
                if ($status) {
                    $status_id = $status->id;
                } else {
                    $status = new CalenderStatus;
                    $status->status = $data['status'];
                    $status->save();
                    $status_id = $status->id;
                }
            }

            $month = date("Y-m", strtotime($data['selectedMonth']));
            $month .= '-01';

            $lastJobNo = ExportCalender::findOrFail($id);

            $dateFormat =  date("F-Y", strtotime($lastJobNo->month));

            // return $data['selectedMonth'];

            if ($data['selectedMonth'] != $dateFormat) {

                $job = date("M", strtotime($month));


                $items = ExportCalender::where('month', $month)->pluck('job_no');

                $maxJob = 0;
                foreach ($items as $item) {
                    $jobNo = (explode("-", $item))[count(explode("-", $item)) - 1];
                    $jobNo = (int)$jobNo;
                    if ($maxJob < $jobNo) $maxJob = $jobNo;
                }


                $job .= '-' . ++$maxJob;
            } else {
                $job = $lastJobNo->job_no;
            }

            $orderManagement = ExportCalender::findOrFail($id);
            $orderManagement->month = $month;
            $orderManagement->job_no = $job;
            $orderManagement->buyer_id = $buyer_id;
            $orderManagement->merchandiser = $data['merchandiser'];
            $orderManagement->fabrication = $data['fabrication'];
            $orderManagement->order_no = $data['order_no'];
            $orderManagement->order_qty = $data['order_qty'];
            $orderManagement->unit_price = $data['unit_price'];
            $orderManagement->total = $data['total'];
            $orderManagement->status_id =  $status_id;
            $orderManagement->update();
            return response()->json([
                'success' => true,
                'message' => 'Calender updated successfully',
            ]);
        }
    }

    public function getData()
    {
        $buyers = Buyer::get();
        $statues = CalenderStatus::get();

        return response()->json([
            'buyers' => $buyers,
            'statuses' => $statues
        ]);
    }

    public function deleteOrder(Request $request)
    {
        $id = $request->params['id'];
        $exportCalender = ExportCalender::where('id', $id)->first();
        $exportCalender->delete();
        return response()->json([
            'success' => true,
            'message' => 'Order delete success',
        ]);
    }

    public function pdfExportCalender()
    {

        $exportCalenders = $this->getCalender();
        return $pdf = Pdf::loadView('pdf.exportCalender', [
            'exportCalenders' => $exportCalenders,
        ])->setPaper('a4', 'landscape');
    }

    public function pdfShiftedOrder()
    {

        $shiftedOrders =  ExportCalender::join('buyers', 'buyers.id', '=', 'export_calenders.buyer_id')
            ->leftJoin('calender_statuses', 'calender_statuses.id', '=', 'export_calenders.status_id')
            ->where('export_calenders.status_id', 1)
            ->orWhere('export_calenders.status_id', null)
            ->select('export_calenders.id', 'export_calenders.job_no', 'export_calenders.merchandiser', 'export_calenders.fabrication', 'export_calenders.order_no', 'export_calenders.order_qty', 'export_calenders.unit_price', 'export_calenders.total', 'buyers.buyer_name', 'calender_statuses.status', 'export_calenders.month')
            ->orderBy('export_calenders.month', 'asc')
            ->orderBy('export_calenders.job_no', 'asc')
            ->get();
        return $pdf = Pdf::loadView('pdf.shiftedOrder', [
            'shiftOrders' => $shiftedOrders,
        ])->setPaper('a4', 'landscape');
    }

    public function printOrder()
    {
        $pdf = $this->pdfExportCalender();
        return $pdf->stream();
    }

    public function downloadOrder()
    {
        $pdf = $this->pdfExportCalender();
        $name = 'export-calender.pdf';
        return $pdf->download($name);
    }
    public function downloadShiftedOrder()
    {
        $pdf = $this->pdfShiftedOrder();
        $name = 'ShiftedOrder.pdf';
        return $pdf->download($name);
    }

    public function shiftOrder()
    {
        $shiftOrders = ExportCalender::join('buyers', 'buyers.id', '=', 'export_calenders.buyer_id')
            ->join('calender_statuses', 'calender_statuses.id', '=', 'export_calenders.status_id')
            ->where('calender_statuses.id', 1)
            ->select('export_calenders.id', 'export_calenders.job_no', 'export_calenders.merchandiser', 'export_calenders.fabrication', 'export_calenders.order_no', 'export_calenders.order_qty', 'export_calenders.unit_price', 'export_calenders.total', 'buyers.buyer_name', 'calender_statuses.status')
            ->orderBy('id', 'desc')
            ->get();

        return view('order_management.shiftOrder', [
            'shiftOrders' => $shiftOrders,
            'page_title' => 'Shift Orders',
            'page_message' => 'All shift order here',
        ]);
    }

    public function editShiftOrder($id)
    {
        $id = decrypt($id);
        $statues = CalenderStatus::whereNot('id', 1)->get();
        $exportCalender = ExportCalender::findOrFail($id);
        return view('order_management.edit_status', [
            'shiftOrders' => $exportCalender,
            'statuses' => $statues,
            'page_title' => 'Edit Status',
            'page_message' => 'Edit your shifted order status',
        ]);
    }

    public function updateShiftOrder(Request $request)
    {
        $status = $request->status;
        $order_id = $request->order_id;

        $request->validate([
            'status' => 'required'
        ]);
        $status = CalenderStatus::where('id', $status)->first();
        $status_id = "";
        if ($status) {
            $status_id = $status->id;
        } else {
            $statuses = new CalenderStatus;
            $statuses->status = $status;
            $statuses->save();
            $status_id = $statuses->id;
        }
        $exportCalender = ExportCalender::findOrFail($order_id);
        $exportCalender->status_id = $status_id;
        $exportCalender->update();
        return redirect()->route('shit.order')->with('success', "Status Update Success");
    }
}
