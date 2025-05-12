@php
   $categories    = \App\Models\Category::select('*')
                     ->with('seo', 'seos', 'tags.infoTag')
                     ->get();
   $xhtmlBodyMenu = '';
@endphp     

<div class="megaMenu">
   <div class="megaMenu_title">
      <ul>
            @php
                $i = 0;
            @endphp
            @foreach($categories as $category)
                  @foreach($category->seos as $seo)
                        @if(!empty($seo->infoSeo->language)&&$seo->infoSeo->language==$language)
                              @php
                                    $classSelected = $i==0 ? 'selected' : null;
                                    ++$i;
                                    // tiện foreach lấy luôn dữ liệu con
                                    $xhtmlBodyMenu .= '<ul data-menu="menu_'.$category->id.'">';
                                    foreach($category->tags as $tag){
                                          if(!empty($tag->infoTag)){
                                                foreach($tag->infoTag->seos as $s){
                                                      if(!empty($s->infoSeo->language)&&$s->infoSeo->language==$language){
                                                            $icon          = !empty($tag->infoTag->icon) ? '<div class="listMenuGroup_icon"><svg><use xlink:href="#'.$tag->infoTag->icon.'"></use></svg></div>' : null;
                                                            $sign          = !empty($tag->infoTag->sign) ? '<div class="listMenuGroup_content_title_tag" style="background:#'.config('main_'.env('APP_NAME').'.sign.'.$tag->infoTag->sign.'.color').'">'.config('main_'.env('APP_NAME').'.sign.'.$tag->infoTag->sign.'.name').'</div>' : null;
                                                            $xhtmlBodyMenu .= '<li>
                                                                              <a href="#" title="" class="listMenuGroup">
                                                                                    '.$icon.'
                                                                                    <div class="listMenuGroup_content">
                                                                                          <div class="listMenuGroup_content_title">
                                                                                          <div>'.$s->infoSeo->title.'</div>
                                                                                          '.$sign.'
                                                                                          </div>
                                                                                          <div class="listMenuGroup_content_description">'.$s->infoSeo->seo_description.'</div>
                                                                                    </div>
                                                                              </a>
                                                                              </li>';
                                                            break;
                                                      }
                                                }
                                                
                                          }
                                    }
                                    $xhtmlBodyMenu .= '</ul>';
                              @endphp
                              <li id="menu_{{ $category->id ?? null }}" onmouseover="openMegaMenu(this.id);" class="{{ $classSelected }}">
                                    <div>{{ $seo->infoSeo->title ?? null }}</div>
                              </li>
                              @break
                        @endif
                  @endforeach
            @endforeach
      </ul>
   </div>
   <div class="megaMenu_content">
      {{-- @php
         $arrayData = [
            0 => [
               [
                     'title' => 'Kết nối đối tác & nhà đầu tư',
                     'subtitle' => 'Mở rộng quan hệ kinh doanh thông qua kết nối với nhà đầu tư, đối tác chiến lược và các dự án phù hợp'
               ],
               [
                     'title' => 'Kết nối cộng sự, mentor & chuyên gia',
                     'subtitle' => 'Tìm kiếm người đồng hành phù hợp để cùng triển khai dự án, tăng cường hiệu quả và chiều sâu chuyên môn'
               ],
               [
                     'title' => 'Hỗ trợ gọi vốn khởi nghiệp',
                     'subtitle' => 'Hướng dẫn, chuẩn bị và kết nối với các nguồn vốn phù hợp (thiên thần, quỹ đầu tư, cộng đồng)'
               ],
               [
                     'title' => 'Tư vấn mô hình & chiến lược kinh doanh',
                     'subtitle' => 'Định hướng mô hình kinh doanh, chiến lược tăng trưởng và tối ưu hóa nguồn lực cho từng giai đoạn phát triển'
               ],
               [
                     'title' => 'Đánh giá và phân tích dự án',
                     'subtitle' => 'Phân tích tính khả thi thị trường, mô hình tài chính, rủi ro pháp lý trước khi ra mắt hoặc gọi vốn'
               ],
               [
                     'title' => 'Tư vấn chuyển đổi số & tối ưu vận hành',
                     'subtitle' => 'Xây dựng lộ trình số hóa, ứng dụng công nghệ vào quản lý và vận hành hiệu quả doanh nghiệp'
               ],
               [
                     'title' => 'Định giá doanh nghiệp & dự án',
                     'subtitle' => 'Tư vấn định giá hợp lý cho startup hoặc SME nhằm phục vụ gọi vốn, M&A hoặc chia cổ phần'
               ]
            ],
            1 => [
               [
                     'title' => 'Đăng ký và thay đổi giấy phép kinh doanh',
                     'subtitle' => 'Hỗ trợ thủ tục pháp lý từ khởi tạo doanh nghiệp, thay đổi thông tin đến đăng ký chi nhánh'
               ],
               [
                     'title' => 'Soạn thảo điều lệ, hợp đồng & thỏa thuận',
                     'subtitle' => 'Cung cấp mẫu và tư vấn chi tiết các loại hợp đồng, điều lệ, biên bản nội bộ, bảo vệ quyền lợi các bên'
               ],
               [
                     'title' => 'Tư vấn pháp lý khởi nghiệp & doanh nghiệp',
                     'subtitle' => 'Cung cấp nền tảng pháp lý vững chắc từ giai đoạn tiền khởi nghiệp đến khi mở rộng quy mô'
               ],
               [
                     'title' => 'Tư vấn & đăng ký sở hữu trí tuệ',
                     'subtitle' => 'Bảo vệ thương hiệu, sản phẩm và nội dung thông qua đăng ký bản quyền, nhãn hiệu, sáng chế'
               ],
               [
                     'title' => 'Đại diện pháp lý & xử lý tranh chấp',
                     'subtitle' => 'Thay mặt doanh nghiệp làm việc với cơ quan quản lý hoặc đối tác trong các vấn đề pháp lý'
               ],
               [
                     'title' => 'Kế toán & khai báo thuế trọn gói',
                     'subtitle' => 'Dịch vụ kế toán hàng tháng, báo cáo thuế, tài chính và hỗ trợ quyết toán cuối năm'
               ],
               [
                     'title' => 'Lập kế hoạch kinh doanh chuyên nghiệp',
                     'subtitle' => 'Soạn thảo kế hoạch kinh doanh chuẩn để trình bày với nhà đầu tư, ngân hàng hoặc đối tác dự án'
               ],
               [
                     'title' => 'Soạn hồ sơ gọi vốn & chào đầu tư',
                     'subtitle' => 'Chuẩn bị pitch deck, executive summary và thư mời đầu tư đúng chuẩn quốc tế'
               ]
            ],
            2 => [
               [
                     'title' => 'Thiết kế website & landing page chuyên nghiệp',
                     'subtitle' => 'Tạo nền tảng online chuẩn UX/UI, dễ quản trị, tối ưu SEO và sẵn sàng cho chuyển đổi'
               ],
               [
                     'title' => 'Phát triển ứng dụng (App) iOS & Android',
                     'subtitle' => 'Xây dựng App di động phù hợp cho MVP hoặc nền tảng chính thức, tương thích đa nền tảng'
               ],
               [
                     'title' => 'Xây dựng hệ thống CRM & ERP',
                     'subtitle' => 'Phát triển công cụ quản lý khách hàng, quy trình và dữ liệu nội bộ linh hoạt, theo đặc thù ngành'
               ],
               [
                     'title' => 'Tích hợp công nghệ AI & tự động hóa',
                     'subtitle' => 'Ứng dụng chatbot, hệ thống automation và phân tích dữ liệu để tối ưu chi phí và nhân sự'
               ],
               [
                     'title' => 'Hạ tầng dữ liệu & dashboard quản trị',
                     'subtitle' => 'Thiết lập hệ thống báo cáo thông minh, hỗ trợ quản lý hiệu quả và ra quyết định nhanh chóng'
               ]
            ],
            3 => [
               [
                     'title' => 'Thiết kế bộ nhận diện thương hiệu',
                     'subtitle' => 'Xây dựng logo, hệ thống màu sắc, kiểu chữ và các ấn phẩm đồng bộ cho doanh nghiệp'
               ],
               [
                     'title' => 'Phát triển chiến lược thương hiệu',
                     'subtitle' => 'Định vị thương hiệu rõ ràng, xây dựng câu chuyện và lộ trình phát triển dài hạn'
               ],
               [
                     'title' => 'Tư vấn thương hiệu cá nhân & xây dựng hình ảnh',
                     'subtitle' => 'Định hướng hình ảnh chuyên gia, diễn giả, nhà sáng lập thông qua chiến lược nội dung và truyền thông cá nhân'
               ],
               [
                     'title' => 'Sản xuất nội dung truyền thông',
                     'subtitle' => 'Thiết kế và triển khai nội dung chuyên nghiệp: video, bài viết, hình ảnh theo chiến dịch'
               ],
               [
                     'title' => 'Quản lý mạng xã hội & kênh truyền thông',
                     'subtitle' => 'Vận hành các kênh social media hiệu quả, cập nhật thường xuyên và tương tác với khách hàng'
               ],
               [
                     'title' => 'Dịch vụ SEO & quảng cáo đa nền tảng',
                     'subtitle' => 'Tối ưu hiển thị trên Google và mạng xã hội, giúp gia tăng khách hàng tiềm năng và doanh thu'
               ],
               [
                     'title' => 'Triển khai chiến dịch ra mắt sản phẩm/dịch vụ',
                     'subtitle' => 'Lên kế hoạch và điều phối truyền thông hiệu quả cho giai đoạn ra mắt quan trọng'
               ],
               [
                     'title' => 'Tổ chức hội thảo, sự kiện & triển lãm',
                     'subtitle' => 'Tổ chức sự kiện offline/online từ A–Z, kết nối cộng đồng và nâng cao uy tín thương hiệu'
               ]
            ]
         ];

      @endphp  

      @php
         $i = 0;
      @endphp
      @foreach($arrayData as $data)
         
         @php
            ++$i;
         @endphp
      @endforeach --}}
      {!! $xhtmlBodyMenu !!}
</div>
@pushonce('scriptCustom')
   <script type="text/javascript">
      function openMegaMenu(id){
        var elemt	= $('#'+id);
        elemt.siblings().removeClass('selected');
        elemt.addClass('selected');
        $('[data-menu]').each(function(){
            var key	= $(this).attr('data-menu');
            if(key==id){
            $(this).css('display', 'grid');
            }else {
                $(this).css('display', 'none');
            }
        });
      }
   </script>
@endpushonce