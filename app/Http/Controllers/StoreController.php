<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Size;
use App\Models\Unit;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Color;
use App\Models\Combo;
use App\Models\Order;
use App\Models\Style;
use App\Models\Challan;
use App\Models\Supplier;
use App\Models\Accessory;
use App\Models\Inventory;
use App\Models\FebricPart;
use App\Models\Fabrication;
use App\Models\YarnBooking;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BookingHistory;
use App\Models\StockInHistory;
use App\Models\YarnAllocation;
use App\Models\StockOutHistory;
use App\Models\NotificationStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    protected function  stockInDashboard(){
        $page_title = 'Dashboard';
        $page_message = 'Store Management Application';

        $orders = Style::leftjoin('orders', 'orders.id', '=', 'styles.order_id')
            ->leftjoin('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->select('styles.id', 'styles.style_no', 'styles.status', 'buyers.buyer_name', 'orders.order_no')
            ->orderBy('styles.id', 'desc')->get();
        return view('dashboard')->with(compact('orders', 'page_title', 'page_message'));
    }


    protected function mrrEntryForm()
    {
        $page_title = 'Stock In';
        $page_message = 'MRR Entry';

        $styles =  Style::leftjoin('orders', 'orders.id', '=', 'styles.order_id')
            ->leftjoin('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->where('styles.order_id', '!=', null)
            ->select('styles.id', 'styles.style_no', 'buyers.buyer_name',)
            ->orderBy('styles.id', 'desc')->get();
        $accessories = Accessory::orderBy('id', 'desc')->get();
        $units = Unit::orderBy('id', 'desc')->get();
        $colors = Color::orderBy('id', 'desc')->get();
        $sizes = Size::orderBy('id', 'desc')->get();
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        $challans = Challan::orderBy('id', 'desc')->get();

        return view('store.mrrEntryForm')->with(compact('page_title', 'page_message', 'styles', 'accessories', 'colors', 'sizes', 'suppliers', 'challans', 'units'));
    }

    protected function stockInSection(Request $request)
    {
        $styles = Style::orderBy('id', 'desc')->get();
        $accessories = Accessory::orderBy('id', 'desc')->get();
        $units = Unit::orderBy('id', 'desc')->get();
        $colors = Color::orderBy('id', 'desc')->get();
        $sizes = Size::orderBy('id', 'desc')->get();
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        $challans = Challan::orderBy('id', 'desc')->get();
        return view('store.stockInForm')->with(compact('styles', 'accessories', 'colors', 'sizes', 'suppliers', 'challans', 'units'));
    }

    protected function getSingleUnit(Request $request)
    {
        $accessory = Accessory::find($request->accessory);
        if ($accessory) {
            return $accessory->unit_id;
        } else {return 0;}
    }

    protected function stockIn(Request $request)
    {
        $data = $request->data;
        $hassError = false;
        $errors = [];
        $rules = [
            'style_no' => 'required|string',
            'accessories_name' => 'required|string',
            'unit' => 'required|string',
            'color_name' => 'nullable|string',
            'size' => 'nullable|string',
            'quantity' => 'required|numeric',
            'received_date' => 'required|string',
            'supplier_name' => 'required|string',
            'mrr_no' => 'required|string',
            'callan_no' => 'required|string',
        ];

        $validator = Validator::make($data, $rules); //$validator->fails()


        if ($validator->fails()) {
            $messages = $validator->errors()->messages();
            foreach ($messages as $key => $message) {
                $errors[$key] = $message[0];
            }
            return $errors;
        } else {
            $callanNo = $data['callan_no'];
            $mrr = $data['mrr_no'];
            $receivedDate = $data['received_date'];
            $collectedBy = $data['collected_by'];
            $quantity = $data['quantity'];

            if (is_numeric($data['style_no'])) {
                $style = Style::find($data['style_no']);
                if ($style) {
                    $styleId = $style->id;
                } else {
                    $errors['style_no'] = 'Enter valid style number';
                    $hassError = true;
                }
            } else {
                try {
                    $style = Style::where('style_no', $data['style_no'])->first();
                    if ($style) {
                        $styleId = $style->id;
                    } else {
                        $style = new Style;
                        $style->style_no = $data['style_no'];
                        $style->status = 2;
                        $style->created_by = auth()->user()->id;
                        $style->save();
                        $styleId = $style->id;
                    }
                } catch (\Throwable $e) {
                    $errors['error'] = 'Operation failed';
                    return $errors;
                }
            }


            if (is_numeric($data['unit'])) {
                $unit = Unit::find($data['unit']);
                if ($unit) {
                    $unitId = $unit->id;
                } else {
                    $errors['unit'] = 'Enter valid unit';
                    $hassError = true;
                }
            } else {
                try {
                    $unit = Unit::where('unit', $data['unit'])->first();
                    if ($unit) {
                        $unitId = $unit->id;
                    } else {
                        $unit = new Unit;
                        $unit->unit = $data['unit'];
                        $unit->created_by = auth()->user()->id;
                        $unit->save();
                        $unitId = $unit->id;
                    }
                } catch (\Throwable $e) {
                    $errors['error'] = 'Operation failed';
                    return $errors;
                }
            }


            if (is_numeric($data['accessories_name'])) {
                $accessory = Accessory::find($data['accessories_name']);
                if ($accessory) {
                    $accessoryId = $accessory->id;
                } else {
                    $errors['accessories_name'] = 'Enter valid accessories name';
                    $hassError = true;
                }
            } else {
                if (!$hassError) {
                    try {
                        $accessory = Accessory::where('accessories_name', $data['accessories_name'])->first();
                        if ($accessory) {
                            $accessoryId = $accessory->id;
                        } else {
                            $accessory = new Accessory;
                            $accessory->accessories_name = $data['accessories_name'];
                            $accessory->unit_id = $unitId;
                            $accessory->created_by = auth()->user()->id;
                            $accessory->save();
                            $accessoryId = $accessory->id;
                        }
                    } catch (\Throwable $e) {
                        $errors['error'] = 'Operation failed';
                        return $errors;
                    }
                }
            }


            if (is_numeric($data['supplier_name'])) {
                $supplier = Supplier::find($data['supplier_name']);
                if ($supplier) {
                    $supplierId = $supplier->id;
                } else {
                    $errors['supplier_name'] = 'Enter valid supplier name';
                    $hassError = true;
                }
            } else {
                try {
                    $supplier = Supplier::where('supplier_name', $data['supplier_name'])->first();
                    if ($supplier) {
                        $supplierId = $supplier->id;
                    } else {
                        $supplier = new Supplier;
                        $supplier->supplier_name = $data['supplier_name'];
                        $supplier->created_by = auth()->user()->id;
                        $supplier->save();
                        $supplierId = $supplier->id;
                    }
                } catch (\Throwable $e) {
                    $errors['error'] = 'Operation failed';
                    return $errors;
                }
            }

            $challan = Challan::where('callan_no', $data['callan_no'])
                                ->where('supplier_id', $supplierId)->first();
            if($challan){$challanId = $challan->id;}
            else{
                $challan = new Challan;
                $challan->callan_no = $data['callan_no'];
                $challan->supplier_id = $supplierId;
                $challan->created_by = auth()->user()->id;
                $challan->save();
                $challanId = $challan->id;
            }





            $colorId = null;
            if ($data['color_name'] != null && $data['color_name'] != "") {
                if (is_numeric($data['color_name'])) {
                    $color = Color::find($data['color_name']);
                    if ($color) {
                        $colorId = $color->id;
                    } else {
                        $errors['color_name'] = 'Enter valid color';
                        $hassError = true;
                    }
                } else {
                    try{
                        $color = Color::where('color_name', $data['color_name'])->first();
                        if ($color) {
                            $colorId = $color->id;
                        } else {
                            $color = new Color;
                            $color->color_name = $data['color_name'];
                            $color->created_by = auth()->user()->id;
                            $color->save();
                            $colorId = $color->id;
                        }
                    } catch (\Throwable $e) {
                        $errors['error'] = 'Operation failed';
                        return $errors;
                    }
                }
            }


            $sizeId = null;
            if ($data['size'] != null && $data['size'] != "") {
                if (is_numeric($data['size'])) {
                    $size = Size::find($data['size']);
                    if ($size) {
                        $sizeId = $size->id;
                    } else {
                        $errors['size'] = 'Enter valid size';
                        $hassError = true;
                    }
                } else {
                    try{
                        $size = Size::where('size', $data['size'])->first();
                        if ($size) {
                            $sizeId = $size->id;
                        } else {
                            $size = new Size;
                            $size->size = $data['size'];
                            $size->created_by = auth()->user()->id;
                            $size->save();
                            $sizeId = $size->id;
                        }
                    } catch (\Throwable $e) {
                        $errors['error'] = 'Operation failed';
                        return $errors;
                    }
                }
            }

            if(!$hassError){
                $mrrItem = StockInHistory::where('style_id', $styleId)
                        ->where('accessories_id', $accessoryId)
                        ->where('color_id', $colorId)
                        ->where('size_id', $sizeId)
                        ->where('callan_id',$challanId)->first();
                if($mrrItem){
                    $errors['error'] = 'This item is already added';
                    return $errors;
                }
            }

            if (!$hassError) {

                $inventory = Inventory::where('style_id', $styleId)->where('accessories_id', $accessoryId)
                    ->where('color_id', $colorId)->where('size_id', $sizeId)->first();
                if ($inventory) {
                    try {
                        $inventory->received_quantity += $quantity;
                        $inventory->stock_quantity += $quantity;
                        $inventory->update();
                    } catch (\Throwable $e) {
                        $errors['error'] = 'Operation failed';
                        return $errors;
                    }
                } else {
                    $errors['error'] = 'No Booking for this item';
                    return $errors;
                    try {
                        $inventory = new Inventory;
                        $inventory->style_id = $styleId;
                        $inventory->accessories_id = $accessoryId;
                        $inventory->color_id = $colorId;
                        $inventory->size_id = $sizeId;
                        $inventory->received_quantity = $quantity;
                        $inventory->stock_quantity = $quantity;
                        $inventory->created_by = auth()->user()->id;
                        $inventory->save();
                    } catch (\Throwable $e) {
                        $errors['error'] = 'Operation failed';
                        return $errors;
                    }
                }

                try {
                    $stockInHistory = new StockInHistory;
                    $stockInHistory->style_id = $styleId;
                    $stockInHistory->accessories_id = $accessoryId;
                    $stockInHistory->color_id = $colorId;
                    $stockInHistory->size_id = $sizeId;
                    $stockInHistory->supplier_id = $supplierId;
                    $stockInHistory->callan_id = $challanId;
                    $stockInHistory->mrr_no = $mrr;
                    $stockInHistory->collected_by = $collectedBy;
                    $stockInHistory->received_date = $receivedDate;
                    $stockInHistory->quantity = $quantity;
                    $stockInHistory->created_by = auth()->user()->id;
                    $stockInHistory->save();
                } catch (\Throwable $e) {
                    $errors['error'] = 'Operation failed';
                    return $errors;
                }
                $this->storein_notification($styleId, $inventory->id, $inventory->created_by, $type = 0);

                $errors['success'] = 'Inserted successfully';
            }
            return $errors;
        }
    }

    protected function mrrListView()
    {
        $page_title = 'Stock In';
        $page_message = 'All MRR Histories';
        return view('store.mrrList')->with(compact('page_title','page_message'));
    }

    protected function mrrList()
    {
        $stockInHistories = StockInHistory::join('styles', 'styles.id', '=', 'stock_in_histories.style_id')
            ->join('accessories', 'accessories.id', '=', 'stock_in_histories.accessories_id')
            ->join('units', 'units.id', '=', 'accessories.unit_id')
            ->leftjoin('colors', 'colors.id', '=', 'stock_in_histories.color_id')
            ->leftjoin('sizes', 'sizes.id', '=', 'stock_in_histories.size_id')
            ->join('suppliers', 'suppliers.id', '=', 'stock_in_histories.supplier_id')
            ->join('challans', 'challans.id', '=', 'stock_in_histories.callan_id')
            ->select(
                'stock_in_histories.id',
                'styles.style_no',
                'accessories.accessories_name',
                'units.unit',
                'colors.color_name',
                'sizes.size',
                'suppliers.supplier_name',
                'challans.callan_no',
                'stock_in_histories.mrr_no',
                'stock_in_histories.collected_by',
                'stock_in_histories.received_date',
                'stock_in_histories.quantity',
            )
            ->orderBy('stock_in_histories.id', 'desc')->get();
        return view('store.mrrTable')->with(compact('stockInHistories'));
    }

    protected function setSession(Request $request)
    {
        session_start();
        $key = $request->key;
        $value = $request->value;
        $_SESSION[$key] = $value;

        return $key;
    }

    protected function viewInventory(Request $request, $id)
    {

        $page_title = 'Stock In';
        $page_message = 'Style Wise Inventory';


        session_start();
        $style_id = custom_decrypt($id);

        $style = Style::findOrFail($style_id);
        $styles =  Style::leftjoin('orders', 'orders.id', '=', 'styles.order_id')
            ->leftjoin('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->where('styles.order_id', '!=', null)
            ->select('styles.id', 'styles.style_no', 'buyers.buyer_name',)
            ->orderBy('styles.id', 'desc')->get();

        $inventories = get_inventories($style_id);

        if (isset($_SESSION["back"]) && $_SESSION["back"] == 1) {
            $_SESSION["back"] = 0;
        } else {
            $_SESSION["style_id"] = $style_id;
        }

        return view('store.inventoryView')->with(compact('page_title','page_message','style_id', 'styles'));
    }

    protected function inventoryGet(Request $request)
    {
        $style_id = $request->style_id;
        $accessories_id = $request->accessories_id;
        $color_id = $request->color_id;
        $size_id = $request->size_id;

        $accessoriesCondition = ['accessories.id', '!=', 0];
        if($accessories_id != null)
            $accessoriesCondition = ['accessories.id', '=', $accessories_id];

        $colorCondition = ['colors.id', '!=', 0];
        if($color_id != null)
            $colorCondition = ['colors.id', '=', $color_id];

        $sizeCondition = ['sizes.id', '!=', 0];
        if($size_id != null)
            $sizeCondition = ['sizes.id', '=', $size_id];

        if (!is_numeric($style_id)) {
            return '<h2 class="text-center text-danger mt-3"> No Inventory</h2>';
        }
        $style = Style::findOrFail($style_id);


        $inventories = Inventory::join('styles', 'styles.id', '=', 'inventories.style_id')
                    ->join('accessories', 'accessories.id', '=', 'inventories.accessories_id')
                    ->join('units', 'units.id', '=', 'accessories.unit_id')
                    ->leftjoin('colors', 'colors.id', '=', 'inventories.color_id')
                    ->leftjoin('sizes', 'sizes.id', '=', 'inventories.size_id')
                    ->where('inventories.style_id', $style_id)
                    ->where([$accessoriesCondition])
                    ->where(function($query)use($color_id,$colorCondition){
                        $query->where([$colorCondition]);
                        if(!$color_id) $query->orWhere('colors.id', '=', null);
                        return $query;
                    })
                    ->where(function($query)use($size_id,$sizeCondition){
                        $query->where([$sizeCondition]);
                        if(!$size_id) $query->orWhere('sizes.id', '=', null);
                        return $query;
                    })
                    ->select(
                        'inventories.id',
                        'styles.style_no',
                        'accessories.accessories_name',
                        'units.unit',
                        'colors.color_name',
                        'sizes.size',
                        'inventories.garments_quantity',
                        'inventories.requered_quantity',
                        'inventories.received_quantity',
                        'inventories.stock_quantity',
                        'inventories.consumption',
                        'inventories.bar_or_ean_code',
                        'inventories.tolerance'
                    )
                    ->orderBy('inventories.id', 'desc')
                    ->get();


        $style = Style::findOrFail($style_id);

        return view('store.style_wise_inventory', [
            'inventories' => $inventories,
            'style' => $style,
        ]);
    }

    protected function inventoryByAjax(Request $request)
    {
        $style_id = $request->id;
        $style = Style::findOrFail($style_id);
        $inventories = get_inventories($style_id);
        return view('store.inventoryTable')->with(compact('inventories'));
    }


    protected function mrrView($mrrId)
    {
        $page_title = 'MRR View';
        $page_message = 'MRR Edit Form';
        $id = custom_decrypt($mrrId);
        $mrr = StockInHistory::findOrFail($id);




        $isStockout = true;

        $styles =  Style::leftjoin('orders', 'orders.id', '=', 'styles.order_id')
            ->leftjoin('buyers', 'buyers.id', '=', 'orders.buyer_id')
            ->where('styles.order_id', '!=', null)
            ->select('styles.id', 'styles.style_no', 'buyers.buyer_name',)
            ->orderBy('styles.id', 'desc')->get();
        $accessories = Accessory::get();
        $units = Unit::get();
        $colors = Color::get();
        $sizes = Size::get();
        $suppliers = Supplier::get();
        $challans = Challan::get();
        return view('store.mrrView')->with(compact('page_title', 'page_message', 'styles', 'accessories', 'colors', 'sizes', 'suppliers','challans', 'units', 'mrr', 'isStockout'));
    }

    protected function updateMrr(Request $request, $id)
    {
        $mrr_id = custom_decrypt($id);
        $mrr = StockInHistory::findOrFail($mrr_id);
        $data = $request->all();

        if (is_numeric($request->supplier_name)) {
            $supplier = Supplier::find($request->supplier_name);
            if ($supplier) {
                $request->supplier_name = $supplier->id;
            } else {
                abort(404);
            }
        } else {
            try {
                $supplier = Supplier::where('supplier_name', $request->supplier_name)->first();
                if ($supplier) {
                    $request->supplier_name = $supplier->id;
                } else {
                    $supplier = new Supplier;
                    $supplier->supplier_name = $request->supplier_name;
                    $supplier->created_by = auth()->user()->id;
                    $supplier->save();
                    $request->supplier_name = $supplier->id;
                }
            } catch (\Throwable $e) {
                abort(404);
            }
        }

        $challan = Challan::where('callan_no', $request->callan_no)
                            ->where('supplier_id', $request->supplier_name)->first();
        if($challan){$challanId = $challan->id;}
        else{
            $challan = new Challan;
            $challan->callan_no = $request->callan_no;
            $challan->supplier_id = $request->supplier_name;
            $challan->created_by = auth()->user()->id;
            $challan->save();
            $challanId = $challan->id;
        }

        $inventory = Inventory::where('style_id', $mrr->style_id)->where('accessories_id', $mrr->accessories_id)
            ->where('color_id', $mrr->color_id)->where('size_id', $mrr->size_id)->first();
        $mrId = $inventory->created_by;

        $change = false;
        if (
            $mrr->style_id != $request->style_no ||
            $mrr->accessories_id !=  $request->accessories_name ||
            $mrr->color_id !=  $request->color_name ||
            $mrr->size_id !=  $request->size
        ) {$change = true;}


        if ($change && $inventory->stock_quantity < $mrr->quantity) {
            return back()->with('errorSweet', 'You can\'t make this update');
        }

        if ($change && $inventory->stock_quantity >= $mrr->quantity) {

            $inventory1 = Inventory::where('style_id', $request->style_no)->where('accessories_id', $request->accessories_name)
                ->where('color_id', $request->color_name)->where('size_id', $request->size)->first();

            if ($inventory1) {
                $inventory1->received_quantity += $request->quantity;
                $inventory1->stock_quantity += $request->quantity;
                $inventory1->update();
                $this->storein_notification($inventory1->style_id, $inventory1->id, $inventory1->created_by, $type = 0);


                $inventory->received_quantity -= $mrr->quantity;
                $inventory->stock_quantity -= $mrr->quantity;
                $inventory->update();
                $this->storein_notification($inventory->style_id, $inventory->id, $inventory->created_by, $type = 1);
            } else {
                return back()->with('errorSweet', 'No booking for this item');
            }
        }

        if (!$change && $request->quantity != $mrr->quantity) {
            if ($mrr->quantity > $request->quantity) {
                $dif = $mrr->quantity - $request->quantity;
                if ($inventory->stock_quantity >= $dif) {
                    $inventory->received_quantity -= $dif;
                    $inventory->stock_quantity -= $dif;
                    $inventory->update();
                    $this->storein_notification($inventory->style_id, $inventory->id, $inventory->created_by, $type = 1);
                } else {
                    return back()->with('errorSweet', 'You can\'t make this update');
                }
            } else {
                $dif = $request->quantity - $mrr->quantity;
                $inventory->received_quantity += $dif;
                $inventory->stock_quantity += $dif;
                $inventory->update();
                $this->storein_notification($inventory->style_id, $inventory->id, $inventory->created_by, $type = 1);
            }
        }

        $mrr->style_id = $request->style_no;
        $mrr->accessories_id = $request->accessories_name;
        $mrr->color_id = $request->color_name;
        $mrr->size_id = $request->size;
        $mrr->supplier_id = $request->supplier_name;
        $mrr->callan_id = $challanId;
        $mrr->mrr_no = $request->mrr_no;
        $mrr->collected_by = $request->collected_by;
        $mrr->received_date = $request->received_date;
        $mrr->quantity = $request->quantity;
        $mrr->updated_by = auth()->user()->id;
        $mrr->update();
        return back()->with('success', 'Updated successfull');
    }

    private function storein_notification($style_no, $inventory_id = null, $mr_id, $type = 0)
    {
        $notification = Notification::where('style_id', $style_no)->where('type', $type)->whereDate('created_at', Carbon::today())->where('received_by', $mr_id)->first();
        if ($notification) {
            $notification->effected_inventory_ids  .= ($notification->effected_inventory_ids != '' ?',':'').$inventory_id;
            $notification->effected_accessories += 1;
            $notification->status = 0;
            $notification->save();
        } else {
            if ($type == 0) {
                $message = 'Accessories Stock in for style';
            }else {
                $message = 'Inventory Update for style';
            }
            $notification = new Notification;
            $notification->style_id = $style_no;
            $notification->message = $message;
            $notification->type = $type;
            $notification->created_by = auth()->id();
            $notification->received_by = $mr_id;
            $notification->effected_inventory_ids = $inventory_id;
            $notification->effected_accessories = 1;
            $notification->save();

            $notificationStatus = NotificationStatus::where('user_id', $mr_id)->first();
            if($notificationStatus){
                $notificationStatus->status = 'on';
                $notificationStatus->update();
            }else{
                $notificationStatus = new NotificationStatus;
                $notificationStatus->user_id = $mr_id;
                $notificationStatus->status = 'on';
                $notificationStatus->save();
            }
        }
    }

    public function seenNotificationAlert(){
        $notificationStatus = NotificationStatus::where('user_id', auth()->user()->id)->first();
        $notificationStatus->status = 'off';
        $notificationStatus->update();
    }


}
