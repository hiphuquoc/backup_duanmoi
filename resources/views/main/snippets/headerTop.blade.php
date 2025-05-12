<div class="headerTop">
   <div class="container">
      <div class="headerTop_item">
         <div class="headerTop_item_hotline">
            <i class="fa-solid fa-phone"></i>phone<span>{{ config('main_'.env('APP_NAME').'.hotline') }}</span>
         </div>
      </div>
      <div class="headerTop_item">
         <div class="headerTop_item_list">
            {{-- <a href="#" class="headerTop_item_list_item">
               Tư vấn khách hàng
            </a> --}}
            <a href="/lien-he-hitour" title="Liên hệ {{ config('main_'.env('APP_NAME').'.company_name') }}" class="headerTop_item_list_item">
               Liên hệ
            </a>
            {{-- <a href="/admin" title="Đăng nhập" class="headerTop_item_list_item">
               Đăng nhập
            </a> --}}
            <div id="js_checkLoginAndSetShow_button" class="headerTop_item_list_item js_toggleModalLogin"><div class="loginBox" onclick="toggleModalCustomerLoginForm('modalLoginFormCustomerBox');">
               <svg><use xlink:href="#icon_sign_in_alt"></use></svg>
               <div class="maxLine_1">Đăng nhập</div>
               </div>
            </div>
         </div>
         {{-- <div class="headerTop_item_language">
            <div class="headerTop_item_language_item vi"></div>
            <div class="headerTop_item_language_item en"></div>
         </div> --}}
      </div>
   </div>
</div>