@extends('layouts.app')

@section('content')
<table width="100%" height="100%">
      <tr>
        <td  height="60" style="padding: 10px; background: #28425e; text-align:right; color:#fff; font-size: 17px">
          <img src="{{ asset('img/logo.png') }}" height="30" alt="">
            |  مركز العمليات والمتابعة
        </td>
        <td style="padding: 10px; background: #28425e; text-align:left; color:#111; font-size: 14px"><!-- Right Side Of Navbar -->
            <a href="{{ route('logout') }}" style="color: #fff"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                تسجيل الخروج
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </td>
      </tr>
      <tr>
        <td style="background:#4d5765">

            <table width="100%" height="100%">
                <tr>
                    <td>
                        <div class="card" style="background-color: #ba1c21">
                            <div class="row">

                                <div class="col-3">
                                    <img width="80" src="{{ asset('img/1b.png') }}" alt="">
                                </div>
                                <div class="col-9 text-center">

                                    <p style="font-size: 17px">المسعفين</p>
                                    <h1 style="font-size: 50px">9,000</h1>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="card" style="background-color: #a89f7c">
                            <div class="row">

                                <div class="col-3">
                                    <img width="80" src="{{ asset('img/2b.png') }}" alt="">
                                </div>
                                <div class="col-9 text-center">

                                    <p style="font-size: 17px">رجال الأمن</p>
                                    <h1 style="font-size: 50px">1,200</h1>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="card" style="background-color: #7e28f3">
                            <div class="row">

                                <div class="col-3">
                                    <img width="80" src="{{ asset('img/3b.png') }}" alt="">
                                </div>
                                <div class="col-9 text-center">

                                    <p style="font-size: 17px">الكشافة</p>
                                    <h1 style="font-size: 50px">4,550</h1>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="card" style="background-color: #ffb924">
                            <div class="row">

                                <div class="col-3">
                                    <img width="80" src="{{ asset('img/4b.png') }}" alt="">
                                </div>
                                <div class="col-9 text-center">

                                    <p style="font-size: 17px">الدفاع المدني</p>
                                    <h1 style="font-size: 50px">12,000</h1>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>


        </td>
        <td width="80%">
          <div id="map"></div>
        </td>

      </tr>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ارسال الامر</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="">ارسال الأمر الى اقرب</label>
              <input type="number" class="form-control" name="" value="10">
            </div>
            <div class="form-group">
              <label for="">من رجال</label>
              <select class="form-control" name="">
                <option value="4">الاسعاف</option>
                <option value="4">الاطفاء</option>
                <option value="4">الشرطة</option>
                <option value="4">الكشافة</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">الاحداثيات</label>
              <h6 id="ll"></h6>
            </div>
            <div class="form-group">
              <label for="">الرسالة</label>
              <textarea id="desc" name="name" class="form-control" rows="5" cols="80" required>نص الأمر</textarea>
            </div>





          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button data-wm="" data-lng="" data-lat="" id="send" type="button" class="btn btn-primary">ارسال الأمر</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">معلومات العنصر</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
                <img src="{{ asset('img/avatar.jpg')}}" class="rounded-circle" width="150" style="border: 6px #ccc solid" alt="">
                <h4 style="padding: 10px 0px">عبدالله أحمد عسيري</h4>
                <p>0096612309023</p>
                <p class="user-info"></p>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">اغلاق</button>
          </div>
        </div>
      </div>
    </div>


@endsection
