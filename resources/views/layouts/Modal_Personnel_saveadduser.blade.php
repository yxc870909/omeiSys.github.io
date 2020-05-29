<!--add_temple-->
<div class="modal fade bs-example-modal-lg" id="confirm_registation" tabindex="-1" role="dialog" aria-labelledby="mymdallModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">  

            <div class="form-horizontal" role="form">

                <div class="form-group">
                    <div class="col-md-offset-1 col-md-10">
                        <h3 class="location"></h3>
                        <p class="date1" style="font-size: 20px;">國曆: </p>
                        <p class="date2" style="font-size: 20px;">農曆: </p>
                        <p class="Dianchuanshi" style="font-size: 20px;">點傳師: </p>
                        <p class="preside" style="font-size: 20px;">操持: </p>
                    </div>
                </div>

                <div class="panel-group" id="agendaModal" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default worker" style="display: none;">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#agendaModal" href="#collapseWork" aria-expanded="false" aria-controls="collapseWork">
                                        辦事人員
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseWork" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    @include('layouts.Modal_Personnel_saveuser_worker')
                                </div>
                            </div>
                        </div>
                                        
                        <div class="panel panel-default joiner">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#agendaModal" href="#collapseJoin" aria-expanded="false" aria-controls="collapseJoin">
                                      掛號人員
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseJoin" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    @include('layouts.Modal_Personnel_saveuser_joiner')
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="save btn btn-primary">送出</button>
            </div>
        </div>
    </div>
</div>