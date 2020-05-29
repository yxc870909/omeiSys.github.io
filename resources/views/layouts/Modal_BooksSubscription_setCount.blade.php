<div class="modal fade bs-example-modal-md" id="setCount" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3>訂閱設定<h3/>
            </div>
            <div class="modal-body">
                
                <form class="form-horizontal" name="set_book" role="form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="area" value="">
                    <input type="hidden" name="year" value="">
                    @foreach($book_types as $typ)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed  open" data-id="{{$typ->value}}" data-toggle="collapse" data-parent="#temple" href="#{{$typ->value}}" aria-expanded="false" aria-controls="">
                                    {{$typ->attribute}}
                                </a>
                             </h4>
                        </div>
                        <div id="{{$typ->value}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body"> 

                                <table class="table">
                                    @foreach($book_types_vals as $val)
                                    @if($typ->attribute == $val->attribute)
                                    <tr>
                                        <td style="font-size: 24px;">{{$val->word}}</td>
                                        <td style="width: 25%;">
                                            <input class="form-control" type="number" name="{{$val->value}}">
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </table>

                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div align="right">
                        <button type="button" class="btn btn-primary right" name="save" aria-expanded="fales">送出</button>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>