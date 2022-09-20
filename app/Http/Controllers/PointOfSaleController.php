<?php

namespace App\Http\Controllers;

use App\Party;
use App\ProductSale;
use App\ProductSaleDetail;
use App\Store;
use App\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
//use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

use App\Classes\item;
use NumberFormatter;

class PointOfSaleController extends Controller
{
    public function print(Request $request,$id,$status){

        // session remove product sale id
        Session::forget('product_sale_id');

        if($status == 'now' || $status == 'list'){
            //print status update
            $productSale = ProductSale::find($id);
            if($status == 'now'){
                $status = 1;
            }else{
                $status = 3;
            }
            $productSale->print_status=$status;
            $productSale->save();

            date_default_timezone_set("Asia/Bangkok");

            $productSale = ProductSale::find($id);
            $productSaleDetails = DB::table('product_sale_details')
                ->select('products.name','product_sale_details.price','product_sale_details.qty','product_sale_details.sub_total')
                ->join('products','product_sale_details.product_id','=','products.id')
                ->where('product_sale_details.product_sale_id',$id)
                ->get();

            //dd($productSale);

            try {
                /* Open the printer; this will change depending on how it is connected */
                $connector = new WindowsPrintConnector("RONGTA 80mm Series Printer");
                //$connector = new NetworkPrintConnector("192.168.0.110", 9100);
                /* Start the printer */
                $printer = new Printer($connector);

                /* Information for the receipt */
                $items=array();
                $subtotal = 0;
                foreach($productSaleDetails as $productSaleDetail){
                    array_push($items,new item($productSaleDetail->name, $productSaleDetail->qty, $productSaleDetail->price));
                    $subtotal += $productSaleDetail->sub_total;
                }
                $grand_total_value = $productSale->total_amount;
                $vat_amount_value = $productSale->vat_amount;
                $discount_amount_value = $productSale->discount_amount;
                $paid_amount_value = $productSale->paid_amount;
                $due_amount_value = $productSale->due_amount;

                $subtotal = new item('Subtotal', '', $subtotal);
                $vat = new item('vat','', $vat_amount_value);
                $discount = new item('discount','', $discount_amount_value);
                $grand_total = new item('Grand Total','', $grand_total_value);
                $paid = new item('Paid','', $paid_amount_value);
                $due = new item('Due','', $due_amount_value);
                $payment_type = new item('Payment Type','', 'Cash');
                //$total = new item('Total','', '14.25', true);


                /* Date is kept the same for testing */
                $date = date('l jS \of F Y h:i:s A');


                /* Print top logo */
                //$logo = EscposImage::load("escpos-php.png", false);
                $logo = EscposImage::load("logo.png", false);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> bitImage($logo);
                /* Name of shop */
                //$printer -> selectPrintMode();
                //$printer -> text("Shop No. 42.\n");
                $printer -> feed();

                /* Title of receipt */
                $printer -> setEmphasis(true);
                $printer -> text("SALES INVOICE\n");
                $printer -> setEmphasis(false);
                $printer -> feed();

                /* Items */
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> setEmphasis(true);
                $printer -> text(new item('Product', 'Qty', 'Tk.'));
                $printer -> setEmphasis(false);
                foreach ($items as $item) {
                    $printer -> text($item);
                }
                $printer -> setEmphasis(true);
                $printer -> text($subtotal);
                $printer -> setEmphasis(false);
                $printer -> feed();

                /* Tax and total */
                $printer -> text($vat);
                $printer -> text($discount);
                $printer -> setEmphasis(true);
                $printer -> text($grand_total);
                $printer -> setEmphasis(false);
                $printer -> feed();

                $printer -> setEmphasis(true);
                $printer -> text($paid);
                $printer -> setEmphasis(false);
                $printer -> text($due);
                $printer -> text($payment_type);
                //$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                //$printer -> text($total);
                $printer -> selectPrintMode();

                /* Footer */
                $printer -> feed(2);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("Thank you for shopping at Simco\n");
                $printer -> text("For trading hours, please visit simco.com.bd\n");
                $printer -> feed(2);
                $printer -> text($date . "\n");
                //dd($printer);

                /* Cut the receipt and open the cash drawer */
                $printer -> cut();
                //$printer -> pulse();

                $printer -> close();

                Toastr::success('Successfully Printed!', 'Success');

            } catch (Exception $e) {
                echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            }
        }else{
            //print status update
            $productSale = ProductSale::find($id);
            $productSale->print_status=2;
            $productSale->save();
            Toastr::success('You can print latter!', 'Success');
        }
        return redirect()->route('productPosSales.create');
    }

    public function printPos(Request $request,$id,$status){

        // session remove product sale id
        Session::forget('product_sale_id');

        if($status == 'list'){

            //print status update
            $productSale = ProductSale::find($id);
            $status = 3;
            $productSale->print_status=$status;
            $productSale->save();

            date_default_timezone_set("Asia/Bangkok");

            $productSale = ProductSale::find($id);
            $productSaleDetails = DB::table('product_sale_details')
                ->select('products.name','product_sale_details.price','product_sale_details.qty','product_sale_details.sub_total')
                ->join('products','product_sale_details.product_id','=','products.id')
                ->where('product_sale_details.product_sale_id',$id)
                ->get();
            Toastr::success('Successfully Printed!', 'Success');
            return view('backend.productPosSale.pos_invoice', compact('productSale','productSaleDetails'));
        }else if($status == 'now'){

            //print status update
            $productSale = ProductSale::find($id);
            $status = 1;
            $productSale->print_status=$status;
            $productSale->save();

            date_default_timezone_set("Asia/Bangkok");

            $productSale = ProductSale::find($id);
            $productSaleDetails = DB::table('product_sale_details')
                ->select('products.name','product_sale_details.price','product_sale_details.qty','product_sale_details.sub_total')
                ->join('products','product_sale_details.product_id','=','products.id')
                ->where('product_sale_details.product_sale_id',$id)
                ->get();
            Toastr::success('Successfully Printed!', 'Success');
            return view('backend.productPosSale.pos_invoice', compact('productSale','productSaleDetails'));
        }else{
            //print status update
            $productSale = ProductSale::find($id);
            $productSale->print_status=2;
            $productSale->save();
            Toastr::success('You can print latter!', 'Success');
        }
        return redirect()->route('productPosSales.create');

    }

    public function invoicePos($id)
    {
        //print status update
        $productSale = ProductSale::find($id);
        $status = 1;
        $productSale->print_status=$status;
        $productSale->save();

        $productSale = ProductSale::find($id);
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$id)->get();
        $transactions = Transaction::where('ref_id',$id)->get();
        $store_id = $productSale->store_id;
        $party_id = $productSale->party_id;
        $store = Store::find($store_id);
        $party = Party::find($party_id);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.productPosSale.invoice', compact('productSale','productSaleDetails','transactions','store','party','digit'));
    }
    public function invoicePosPrint($id)

    {
        $productSale = ProductSale::find($id);
        $productSaleDetails = ProductSaleDetail::where('product_sale_id',$id)->get();
        $transactions = Transaction::where('ref_id',$id)->get();
        $store_id = $productSale->store_id;
        $party_id = $productSale->party_id;
        $store = Store::find($store_id);
        $party = Party::find($party_id);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.productPosSale.invoice-print', compact('productSale','productSaleDetails','transactions','store','party','digit'));
//        return view('backend.productSale.invoice-print');
    }
}
