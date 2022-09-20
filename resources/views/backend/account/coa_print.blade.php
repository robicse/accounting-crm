@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Accounts</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h5 class="tile-title">COA Print View</h5>
                <div class="table-responsive">
                     <table cellpadding="0" cellspacing="0" border="1px solid #000" width="99%" style="text-align: left" >
                    @php
                        $accounts = DB::table('accounts')
                            ->where('IsActive',1)
                            ->Orderby('HeadCode','asc')
                            ->get();

                        $row_count = count($accounts);

                        for ($i = 0; $i < $row_count; $i++)
                        {
                            $account_labels = DB::table('accounts')
                            ->select(DB::raw('MAX(HeadLevel) as MHL'))
                            ->where('IsActive',1)
                            ->first();

                            $maxLevel = $account_labels->MHL;
                            //dd($account_labels);

                            $HL=$accounts[$i]->HeadLevel;
                            $Level=$maxLevel+1;
                            $HL1=$Level-$HL;

                            echo '<tr>';
                            for($j=0; $j<$HL; $j++)
                            {
                                echo '<td>&nbsp;</td>';
                            }
                            echo '<td>'.$accounts[$i]->HeadCode.'</td>';
                            echo '<td colspan='.$HL1.'>'.$accounts[$i]->HeadName.'</td>';
                            echo '</tr>';
                        }

                    @endphp
                </table>
                    <div class="row d-print-none mt-2">
                        <div class="col-12 text-right">
                            <input id="printpagebutton" class=" btn btn-primary " type="button" value="Print Now" onclick="printpage()"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        function printpage() {
            //Get the print button and put it into a variable
            var printButton = document.getElementById("printpagebutton");
            //Set the button visibility to 'hidden'
            printButton.style.visibility = 'hidden';
            //Print the page content
            window.print();
            //Restore button visibility
            printButton.style.visibility = 'visible';
        }
    </script>
@endsection

@section('footer')

@endsection
