<section id="create">
<div class="inner">
<h2>انشاء عرض جديد</h2>

@if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif

<form action="{{ route('offer.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="row100">
    <div class="my-col">
      <div class="inputBox">
        <input type="text" name="name" id="name"  required>
        <span class="text">الاسم العرض</span>
        <span class="line"></span>
      </div>
    </div>
    <div class="my-col">
      <div class="inputBox">
        <input type="text" name="phone" id="phone" required>
        <span class="text">رقم الهاتف</span>
        <span class="line"></span>
      </div>
    </div>
  </div>
  <div class="row100">
    <div class="my-col">
      <div class="inputBox">
        <input type="text" name="address" id="address" required>
        <span class="text">العنوان</span>
        <span class="line"></span>
      </div>
    </div>
    <div class="my-col">
      <div class="inputBox logo-or-name">
        <input type="text" name="company_name" id="company_name" class="company_name not-required">
        <input type="File" name="company_logo" id="company_name"  class="logo not-required">
        <span class="text">شعار او اسم الشركة</span>
        <span class="line"></span>
        <sup style="color:rgb(190, 107, 107);top: -35px;right: 170px;">اختياري*</sup>
      </div>
    </div>
  </div>

  <div class="row100">
    <div class="my-col">
      <div class="inputBox">
        <input type="date" id="date" name="date" class="not-required">
        <span class="text">تاريخ انتهاء المسابقة</span>
        <span class="line"></span>
        <sup style="color:rgb(190, 107, 107);top: -35px;right: 170px;">اختياري*</sup>
      </div>
    </div>
    <div class="my-col">
      <div class="inputBox">
        <input type="time" id="time" name="time"  value="00:00:00" class="not-required">
        <span class="text">وقت انتهاء المسابقة</span>
        <span class="line"></span>
        <sup style="color:rgb(190, 107, 107);top: -35px;right: 170px;">اختياري*</sup>
      </div>
    </div>
  </div>



  

  <div class="row100">
    <div class="my-col">
      <div class="inputBoxCheck">
        <input type="checkbox" name="show_in_home" id="show_in_home">
        <span class="text" for="show_in_home">عرض في الصفحة الرئيسية:</span>
      </div>
    </div>
  </div>
  <div class="row100">
    <div class="my-col">
      <div class="inputBoxCheck">
        <input type="checkbox" name="share_link" id="share_link">
        <span class="text" for="share_link">الربح دون مشاركة الرابط:</span>
      </div>
    </div>
  </div>
  <div class="offers"  >
    <div id="dynamicAddOffer">
      <div class="row100">
        <div class="my-col">
          <div class="inputBox">
            <input type="text" name="addMoreInputFields[0][value]" id="addMoreInputFields[0][value]">
            <span class="text">قيمة العرض او صورة 1</span>
            <span class="line"></span>
          </div>
        </div>
        <div class="my-col">
          <div class="inputBox">
            <input type="file" name="addMoreInputFields[0][image]" id="addMoreInputFields[0][image]" class="not-required">     
            <span class="line"></span>
          </div>
        </div>
        <div class="my-col">
          <div class="inputBox">
            <input type="number" name="addMoreInputFields[0][count]" id="addMoreInputFields[0][count]" min="1" required>
            <span class="text" style="font-size:17px">عدد الاشخاص الذين سيحصلون عليه؟</span>
            <span class="line"></span>
          </div>
        </div>
      </div> 
    </div>
    
    
    <div class="row100">
      <div class="my-col">
        <button type="button" name="add" id="dynamic-addOffers" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i></button>        
        <button type="button" class="btn  btn-danger" data-bs-toggle="popover" title="ملاحظة:" data-bs-content="يجب تحديد حقل واحد ، إما صورة العرض أو قيمة العرض."><i class="fas fa-question"></i></button>
      </div>
    </div>
  </div>
  <div class="row100">
    <div class="my-col">
      <div class="inputBox textarea">
        <textarea name="roles" id="roles" cols="30" rows="10" required></textarea>
        <span class="text">اكتب الققوانين الخاصة بك هنا</span>
        <span class="line"></span>
      </div>
    </div>
  </div>

  
  

  <div class="row100">
    <div class="my-col">
    
        <input type="submit" value="انشاء">
    
    </div>
  </div>
</form>
</div>
</section>