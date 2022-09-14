
    <section id="work_type">


        <div  class="row">

            <div class="col-12 text-center my-3 p-4">

                <a href="/bbs/work_type_set.php?work_type=CAPO"  class="btn btn-sq-lg btn-primary text-light  p-4 w-75">
                    <br>
                    <i class="fas fa-book fa-4x"></i>
                    <p class="mt-4">
                    Genuine product
                    <br>
                    <strong>(주)카포 작업</strong>
                    </p>

                </a>

            </div>


            <div class="col-12 text-center my-3 p-4">

                <a href="javascript:confRetProduct()"  class="btn btn-sq-lg btn-danger text-light p-4 w-75">
                    <br>
                    <i class="fas fa-book fa-4x"></i>

                    <p class="mt-4">Return Product
                        <br>
                        <strong>(유)카포 작업</strong>
                    </p>



                </a>

            </div>

        </div>

    </section>

<script>
    function confRetProduct(){
        var cf = confirm('반품 작업으로 선택하시겠습니까?');
        if(cf){
            moveUrl('/bbs/work_type_set.php?work_type=X');
        }
    }
</script>