<?php if($is_school_member) {?>
<!---   학교 회원   > 단축 메뉴    -------------------------------------------------------------------------------------------------->

    <section id="short_menu">
        <div class="container">



            <ul class="row list-unstyled" id="grid">



                <!-----   1 row   ------------------------------------------------------------------------------------------>

                <li class="col-4  col-md-2 m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-green-light text-center p-3">

                            <svg onclick="moveUrl('<?php echo G5_BBS_URL ?>/gmember_worktime.php')" width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-alarm shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="#"  onclick="moveUrl('<?php echo G5_BBS_URL ?>/gmember_worktime.php')" class="card-title text-size-2 text-dark">업무시간 설정</a>
                            <p class="card-text  text-size-4">Work Time</p>
                        </div>
                    </div>
                </li>

                <li class="col-4 col-md-2  m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-teal text-center p-3">




                            <svg  onclick="moveUrl('<?php echo G5_BBS_URL ?>/gmember_charge.php')"  width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-newspaper shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5v-11zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5H12z"/>
                                <path d="M2 3h10v2H2V3zm0 3h4v3H2V6zm0 4h4v1H2v-1zm0 2h4v1H2v-1zm5-6h2v1H7V6zm3 0h2v1h-2V6zM7 8h2v1H7V8zm3 0h2v1h-2V8zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="#"  onclick="moveUrl('<?php echo G5_BBS_URL ?>/gmember_charge.php')"  class="card-title text-size-2 text-dark">월별 요금현황</a>
                            <p class="card-text text-size-4">Monthly Charge</p>
                        </div>
                    </div>
                </li>

                <li class="col-4 col-md-2  m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-indigo-light text-center p-3">


                            <svg onclick="moveUrl('<?php echo G5_BBS_URL ?>/callmapping_list.php')" width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-telephone-outbound shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1H11.5a.5.5 0 0 1-.5-.5z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="#"  onclick="moveUrl('<?php echo G5_BBS_URL ?>/callmapping_list.php')"  class="card-title text-size-2 text-dark">안심발신 내역</a>
                            <p class="card-text text-size-4">TNMS Log</p>
                        </div>
                    </div>
                </li>




                <!-----   2 row   ------------------------------------------------------------------------------------------>

                <li class="col-4  col-md-2 m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-warning text-center p-3">


                            <svg onclick="moveUrl('<?php echo G5_BBS_URL ?>/gmember_list.php')" width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-person-lines-fil shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="javascript:moveUrl('<?php echo G5_BBS_URL ?>/gmember_list.php')" class="card-title text-size-2 text-dark">교사등록 관리</a>
                            <p class="card-text fs-14 text-size-4">Member Mgr</p>
                        </div>
                    </div>
                </li>

                <li class="col-4 col-md-2  m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-pink-lighter text-center p-3">

                            <svg  onclick="moveUrl('<?php echo G5_BBS_URL ?>/sms_statics_daily.php')"  width="2em" height="2em" viewBox="0 0 16 16"  class="bi bi-list-task shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
                                <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
                                <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
                            </svg>



                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="javascript:moveUrl('<?php echo G5_BBS_URL ?>/sms_statics_daily.php')"  class="card-title text-size-2 text-dark">일별 발송내역</a>
                            <p class="card-text fs-14 text-size-4">SMS Daily </p>
                        </div>
                    </div>
                </li>

                <li class="col-4 col-md-2  m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-deep-orange-light  text-center p-3" >



                            <svg  onclick="moveUrl('<?php echo G5_BBS_URL ?>/sms_statics_monthly.php')" width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-journal-text shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                                <path fill-rule="evenodd" d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="javascript:moveUrl('<?php echo G5_BBS_URL ?>/sms_statics_monthly.php')" class="card-title text-size-2 text-dark">월별 발송내역</a>
                            <p class="card-text fs-14 text-size-4">SMS Monthly </p>
                        </div>
                    </div>
                </li>


            </ul>
        </div>

    </section>


<? } ?>

<?php if($is_teacher_member) {?>

    <!---   교직원 회원   > 단축 메뉴    -------------------------------------------------------------------------------------------------->
    <section id="short_menu">
        <div class="container">

            <ul class="row list-unstyled" id="grid">

                <!-----   1 row   ------------------------------------------------------------------------------------------>

                <li class="col-4 col-md-2 m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-warning text-center p-3">

                            <svg onclick="moveUrl('<?php echo G5_BBS_URL ?>/sms_write.php')" width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-chat-left-dots shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v11.586l2-2A2 2 0 0 1 4.414 11H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="javascript:moveUrl('<?php echo G5_BBS_URL ?>/sms_write.php')" class="card-title text-size-1 text-dark">문자 보내기</a>
                            <p class="card-text fs-14 text-size-3">SMS Message</p>
                        </div>
                    </div>
                </li>

                <li class="col-4 col-md-2  m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-pink-lighter text-center p-3">

                            <svg  onclick="moveUrl('<?php echo G5_BBS_URL ?>/sms_history_list.php')"  width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-list-task shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
                                <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
                                <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="javascript:moveUrl('<?php echo G5_BBS_URL ?>/sms_history_list.php')" class="card-title text-size-1 text-dark">문자발송 내역</a>
                            <p class="card-text fs-14 text-size-3">SMS Log</p>
                        </div>
                    </div>
                </li>

                <li class="col-4 col-md-2  m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-deep-orange-light  text-center p-3">

                            <svg onclick="moveUrl('<?php echo G5_BBS_URL ?>/callmapping_list.php')"  width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-telephone-outbound  shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1H11.5a.5.5 0 0 1-.5-.5z"/>
                            </svg>


                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="moveUrl('<?php echo G5_BBS_URL ?>/callmapping_list.php')"  class="card-title text-size-1 text-dark">안심발신 내역</a>
                            <p class="card-text fs-14 text-size-3">TNMS Log</p>
                        </div>
                    </div>
                </li>


                <!-- 2 row   ------------------------------------------------------------------->

                <li class="col-4 col-md-2  m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-blue-light text-center p-3">

                           <svg onclick="moveUrl('<?php echo G5_BBS_URL ?>/call_cdr_list.php')"  width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-telephone-inbound-fill shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="#"  onclick="moveUrl('<?php echo G5_BBS_URL ?>/call_cdr_list.php')" class="card-title text-size-1 text-dark">050 수신내역</a>
                            <p class="card-text fs-14 text-size-3">SNMS Log</p>
                        </div>
                    </div>
                </li>


                <li class="col-4 col-md-2  m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-green-light text-center p-3">

                            <svg onclick="moveUrl('<?php echo G5_BBS_URL ?>/member_worktime.php')" width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-alarm shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="#"  onclick="moveUrl('<?php echo G5_BBS_URL ?>/member_worktime.php')" class="card-title text-size-1 text-dark">업무시간 설정</a>
                            <p class="card-text fs-14 text-size-3">Work Time</p>
                        </div>
                    </div>
                </li>

                <li class="col-4  col-md-2 m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-teal text-center p-3">

                            <svg  onclick="moveUrl('<?php echo G5_BBS_URL ?>/sms_num_book.php')"  width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-wallet shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5V3zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a1.99 1.99 0 0 1-1-.268zM1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="#"  onclick="moveUrl('<?php echo G5_BBS_URL ?>/sms_num_book.php')"  class="card-title text-size-1 text-dark">전화번호부</a>
                            <p class="card-text fs-14 text-size-3">Phone Book</p>
                        </div>
                    </div>
                </li>

                <!--
                <li class="col-4  col-md-2 m-0 p-0">
                    <div class="card m-1">
                        <div class="card-header bg-indigo-light text-center p-3">

                            <svg  onclick="moveUrl('<?php echo G5_BBS_URL ?>/settings_noti.php')"  width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-bell shortcut-logo img-btn" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z"/>
                                <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                            </svg>

                        </div>
                        <div class="card-body px-1 py-2 text-center">
                            <a href="#"  onclick="moveUrl('<?php echo G5_BBS_URL ?>/settings_noti.php')"  class="card-title text-size-1 text-dark">알림설정</a>
                            <p class="card-text fs-14 text-size-3">Notification</p>
                        </div>
                    </div>
                </li>
        -->


            </ul>
        </div>

    </section>

    <!-- only pc screen -->
    <hr class="d-none d-md-block">
<? } ?>

