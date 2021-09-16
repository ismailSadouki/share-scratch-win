<section>
    <div class="inner">
        <h2>تم انشاء العرض الخاص بك</h2>
        <div id="square" >

          <div class="square">
              <span></span>
              <span></span>
              <span></span>
              <div class="content">
                  <h2>تم بنجاح!</h2>
                  <p>يمكنك الآن مشاركة رابط العرض الخاص بك في اي مكان!</p>
                  <a href="https://wa.me/?text={{ url("/offer/show/{$url_share}") }}" target="_blank" id="url_share">مشاركة</a> <br>
                  <a href="{{ url("/offer/show/{$url_share}") }}" class="d-none" id="url_share">مشاركة</a>
                  <input type="submit" value="نسخ الرابط" class="btn btn-primary" id="copy">
              </div>
          </div>
        </div> 
    </div>
  </section>