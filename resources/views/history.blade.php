@extends('layouts.main')

@section('title', 'HISTORY')

@section('style')
    <style>
    
    </style>
@endsection

@section('content')

<div class="summary-content-body" style="width: 99%;height: 599px;color: white;">
    <table style="width: 100%;">
        <thead style="font-size: 20px;">
            <tr style="height: 32px;">
                <td style="width: 637px;">ITEMS</td>
                <td style="width: 304px;">QTY</td>
                <td style="width: 98px;">PRICE</td>
            </tr>
        </thead>
        <tbody>

            <tr style="height: 27px;"></tr>

            <tr>
                <td colspan="3">
                    <div style="width: 100%;height: 500px;overflow: scroll;">

                    <!--  -->

                        <table>

                        
                            <tbody>

                            @for($i = 0; $i <= 94; $i++)

                            <tr style="height:77px;">

                                <td style="width: 637px;">
                                    <div style="display: inline-flex;">
                                        <div style="width: 77px;height: 77px;border: 1px solid white;background: url(&quot;https://www.thesun.co.uk/wp-content/uploads/2016/09/nintchdbpict000264481984.jpg?w=960&quot;);background-size: 150% auto;background-repeat: no-repeat;border-radius: 50%;"></div>
                                    
                                        <div style="width: 436px;font-size: 17px;word-break: break-word;padding: 25px 15px 0px 15px;">
                                    
                                            <strong>ハンバーグ（ステーキ・おろし ・てりやき）</strong>
                                        
                                        </div>
                                    </div>
                                </td>
                                
                                <td style="width: 304px;padding: 0px 15px 0px 0px;">

                                    <!-- s BUTTON -->

                                    <button class="btn btn-default" style="border-radius: 56px;background: #ffffff;text-decoration: none;width: 200px;height: 100%;text-align: center;padding: 0;">

                                        <div class="row" style="margin: 0 auto;height: 53px;display: inline-flex;padding: 0;">

                                            <div class="" style="height: 40px;width: 40px;">
                                                <a style="padding: 0;">
                                                    <img src="{{ url('/image/icons/Male-Blue.png') }}" style="width: 40px;border-radius: 20px;">
                                                </a>
                                            </div>
                                            
                                            <div class="" style="height: 40px;width: 40px;padding-top: 6px;">
                                                <span style="font-size: 20px;">
                                                    <strong>99</strong>
                                                </span>
                                            </div>
                                            
                                            <div class="" style="height: 40px;width: 40px;">
                                                <a style="padding: 0;">
                                                    <img src="{{ url('/image/icons/Female-Pink.png') }}" style="width: 40px;border-radius: 20px;">
                                                </a>
                                            </div>
                                            
                                            <div class="" style="height: 40px;width: 40px;padding-top: 6px;">
                                                <span style="font-size: 20px;">
                                                    <strong>99</strong>
                                                </span>
                                            </div>
                                            

                                        </div>
                                        
                                    </button>

                                    <!-- e BUTTON -->

                                </td>

                                <td style="display: inline-flex;padding: 0;width: 98px;">
                                
                                    <div style="position: relative;height: 100%;margin-top: 20px;"> 
                                        <span style="font-size: 20px;">
                                            <strong>￥100,000</strong>
                                        </span>
                                    </div> 

                                </td>

                            </tr>

                            <tr style="height: 20px;"></tr>

                            @endfor
                            
                            </tbody>

                        </table>

                    <!--  -->
                        
                    </div>
                </td>
            </tr>

            <tr style="height: 7px;"></tr>

            <tr style="height: 47px;">
                <td colspan="3" align="right">
                    <span style="font-size: 25px;">
                        <strong>Total </strong>
                        <strong style="margin-left: 10px;">￥999,999</strong>
                    </span>
                </td>
            </tr>

            <tr style="height: 73px;">
                <td colspan="3">

                    <!-- <div style="width: 160px;float: left;">

                        <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100%;border-radius: 25px;border: 2px solid #634e11;color: #a67c00;height: 48px;font-size: 15px;">Cancel Order</button>

                    </div> -->

                    <div style="width: 160px;float: right;">

                        <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100%;border-radius: 25px;border: 2px solid #634e11;background-color: #a67c00;color: white;height: 48px;font-size: 15px;">Back</button>

                    </div>

                </td>
            </tr>

        </tbody>
    </table>

</div>

<!-- Error Modal -->
<div id="error_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm" style="top: 8em;width:387px;">

        <!-- Modal content-->
        <div class="modal-content" style="height: 390px;padding: 0px 30px 0px 30px;">

            <!-- Content header-->
            <div class="modal-header" style="border: 0px;padding: 0px;">

                <div>
                    <h2 style="margin: 0;height: 40px;font-size: 30px;text-align: center;padding-top: 5px;">Sorry</h2>
                    <p style="    font-size: 17px;margin: 0;text-align: left;word-break: break-word;padding-top: 40px;">Something went terribly wrong. Would you like to try again?</p>
                </div>

            </div>

            <!-- Content body -->
            <div class="modal-body" style="padding: 0;text-align: center;">

                <div style="padding-top: 20px;">
                    <i class="fa fa-times-circle-o" aria-hidden="true" style="color: #a70000;font-size: 117px;height: 100px;width: 100px;"></i>
                </div>

                <div style="margin: 15px 0px 20px 0px;text-align: left;">
                    <p style="font-size: 17px;">Error Code: <strong>505</strong></p>
                </div>

            </div>

            <!-- Content footer -->
            <div class="modal-footer" style="text-align: center;border-top: 0px;padding-top: 22px;padding: 0;">        
                
                <div style="width: 152px;float: left;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100%;border-radius: 25px;border: 2px solid #634e11;background-color: #a67c00;color: white;height: 48px;font-size: 15px;">YES</button>
                </div>

                <div style="width: 152px;float: right;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100%;border-radius: 25px;border: 2px solid #634e11;background-color: #ffffff;color: #a67c00;height: 48px;font-size: 15px;">NO</button>
                </div>
    
            </div>

        </div>

    </div>
</div>

@endsection

@section('script')
    
@endsection