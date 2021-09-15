@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')

    @isset($url_share)
    
    @include('partials.share_link')
 
    @else     

        @include('partials.form_create')
    @endisset
@endsection
@section('scripts')


    @if(isset($url_share))
        <script>
          $(document).on('click', '#copy', function(e) {
              e.preventDefault();
              var $temp = $("<input>");
              var $url = $('#url_share').attr('href');
              $("body").append($temp);
              $temp.val($url).select();
              document.execCommand("copy");
              $temp.remove();
          })
      </script>
    @else    

      <!-- add Offer Inputs -->
      <script type="text/javascript">
        var x = 0;
        $("#dynamic-addOffers").click(function () {
            ++x;
            $("#dynamicAddOffer").append('\
            <div class="row100">\
              <div class="my-col">\
                <div class="inputBox">\
                  <input type="text" name="addMoreInputFields['+ x +'][value]" id="addMoreInputFields['+ x +'][value]"">\
                  <span class="text">قيمة العرض او صورة '+ (x + 1) +'</span>\
                  <span class="line"></span>\
                </div>\
              </div>\
              <div class="my-col">\
                <div class="inputBox">\
                  <input type="file" name="addMoreInputFields['+ x +'][image]" id="addMoreInputFields['+ x +'][image]" class="not-required">\
                  <span class="line"></span>\
                </div>\
              </div>\
              <div class="my-col">\
                <div class="inputBox">\
                  <input type="number" name="addMoreInputFields['+ x +'][count]" id="addMoreInputFields['+ x +'][count]" min="1" required>\
                  <span class="text" style="font-size:17px">عدد الاشخاص الذين سيحصلون عليه؟</span>\
                  <span class="line"></span>\
                </div>\
              </div>\
            </div>\
            ');
        });
       
    </script>  


  {{-- only one field required company_name or company_logo --}}
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          const inputs = Array.from(document.querySelectorAll('input[name=company_name], input[name=company_logo]'));
          const inputListener = e => inputs.filter(i => i !== e.target).forEach(i => i.required = !e.target.value.length);

          inputs.forEach(i => i.addEventListener('input', inputListener));
      });
    </script>

    <!-- popovers -->
    <script type="text/javascript">
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
      var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
      })
      var popover = new bootstrap.Popover(document.querySelector('.example-popover'), {
        container: 'body'
      })
    </script>
    @endif

@endsection