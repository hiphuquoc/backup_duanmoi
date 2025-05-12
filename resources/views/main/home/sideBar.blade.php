<!-- Lọc theo tags-->
<div class="sidebarBox">
    <div class="sidebarBox_title">
        Lọc theo Tags
    </div>
    <div class="sidebarBox_box">
        <div class="sidebarBox_box_tags">
            <div class="sidebarBox_box_tags_item">
                Được xem nhiều
            </div>
            <div class="sidebarBox_box_tags_item">
                Đang gọi vốn
            </div>
            <div class="sidebarBox_box_tags_item">
                Chuyển đổi số
            </div>
            <div class="sidebarBox_box_tags_item">
                Công nghệ cao
            </div>
            <div class="sidebarBox_box_tags_item">
                Xu hướng
            </div>
            <div class="sidebarBox_box_tags_item">
                AI
            </div>
            <div class="sidebarBox_box_tags_item">
                Đã thẩm định
            </div>
            <div class="sidebarBox_box_tags_item">
                Tiềm năng cao
            </div>
        </div>

    </div>
</div>
<!-- Lọc theo qyu mô -->
<div class="sidebarBox">
    <div class="sidebarBox_title">
        Lọc theo Quy mô
    </div>
    <div class="sidebarBox_box">
        <div class="sidebarBox_box_tags">
            <div class="sidebarBox_box_tags_item">
                Quốc tế
            </div>
            <div class="sidebarBox_box_tags_item">
                Quốc gia
            </div>
            <div class="sidebarBox_box_tags_item">
                Địa phương
            </div>
        </div>

    </div>
</div>
<!-- Lọc theo nghành nghề -->
<div class="sidebarBox">
    <div class="sidebarBox_title">
        Lọc theo Nghành nghề
    </div>
    <div class="sidebarBox_box">
        <div class="sidebarBox_box_tags">
            @php
                $arrayData = [
                    // 🖥️ Công nghệ – Số hóa
                    "Công nghệ thông tin & Phần mềm",
                    "Ứng dụng di động & Khởi nghiệp số",
                    "Thương mại điện tử",
                    // 📚 Giáo dục – Y tế – Đời sống
                    "Giáo dục & Đào tạo",
                    "Y tế & Chăm sóc sức khỏe",
                    "Thể thao & Thể hình",
                    // 💼 Kinh doanh – Dịch vụ – Tư vấn
                    "Tài chính & Kế toán",
                    "Marketing & Truyền thông",
                    "Dịch vụ tư vấn & chuyên môn",
                    // 🏗️ Sản xuất – Phân phối – Hạ tầng
                    "Sản xuất & Gia công",
                    "Vận tải & Logistics",
                    "Bất động sản & Xây dựng",
                    "Năng lượng & Môi trường",
                    // 🛍️ Tiêu dùng – Bán lẻ – F&B
                    "F&B – Thực phẩm & Đồ uống",
                    "Thời trang & Làm đẹp",
                    "Chuỗi cửa hàng & bán lẻ",
                    "Du lịch & Dịch vụ lưu trú",
                    "Giải trí, Nghệ thuật & Truyền hình",
                    // 🌾 Nông nghiệp
                    "Nông nghiệp & Công nghệ nông nghiệp",
                    // 🧩 Khác
                    "Khác",
                ];
            @endphp     
            @foreach($arrayData as $data)
                <div class="sidebarBox_box_tags_item">
                    {{ $data }}
                </div>
            @endforeach
        </div>

    </div>
</div>
<!-- Dịch vụ-->
<div class="sidebarBox">
    <div class="sidebarBox_title">
        Dịch vụ có thể bạn cần?
    </div>
    <div class="sidebarBox_box">
        <ul class="listServices">
            <li>
                <a href="#" title="Liên hệ {{ config('main_'.env('APP_NAME').'.company_name') }}" class="listMenuGroup">
                    <div class="listMenuGroup_icon">
                        <svg><use xlink:href="#icon_chart"></use></svg>
                    </div>
                    <div class="listMenuGroup_content">
                        <div class="listMenuGroup_content_title">
                            <div>Dự án kinh doanh</div>
                        </div>
                        <div class="listMenuGroup_content_description">Các dự án đang gọi vốn, tìm người đồng hành phù hợp để cùng phát triển ý tưởng</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" title="Liên hệ {{ config('main_'.env('APP_NAME').'.company_name') }}" class="listMenuGroup">
                    <div class="listMenuGroup_icon">
                        <svg><use xlink:href="#icon_land"></use></svg>
                    </div>
                    <div class="listMenuGroup_content">
                        <div class="listMenuGroup_content_title">
                            <div>Dự án bất động sản</div>
                            <div class="listMenuGroup_content_title_tag">mới</div>
                        </div>
                        <div class="listMenuGroup_content_description">Cơ hội đầu tư bất động sản hấp dẫn, kết nối với các dự án uy tín và tiềm năng</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" title="Liên hệ {{ config('main_'.env('APP_NAME').'.company_name') }}" class="listMenuGroup">
                    <div class="listMenuGroup_icon">
                        <svg><use xlink:href="#icon_chart"></use></svg>
                    </div>
                    <div class="listMenuGroup_content">
                        <div class="listMenuGroup_content_title">
                            <div>Nhượng quyền</div>
                            <div class="listMenuGroup_content_title_tag">mới</div>
                        </div>
                        <div class="listMenuGroup_content_description">Khởi nghiệp dễ dàng với cơ hội nhượng quyền từ các thương hiệu uy tín</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" title="Liên hệ {{ config('main_'.env('APP_NAME').'.company_name') }}" class="listMenuGroup">
                    <div class="listMenuGroup_icon">
                        <svg><use xlink:href="#icon_handshake"></use></svg>
                    </div>
                    <div class="listMenuGroup_content">
                        <div class="listMenuGroup_content_title">
                            <div>Đối tác</div>
                        </div>
                        <div class="listMenuGroup_content_description">Kết nối đối tác toàn quốc, tìm nguồn hàng chất lượng để tối ưu hóa kinh doanh</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" title="Liên hệ {{ config('main_'.env('APP_NAME').'.company_name') }}" class="listMenuGroup">
                    <div class="listMenuGroup_icon">
                        <svg><use xlink:href="#icon_wallet"></use></svg>
                    </div>
                    <div class="listMenuGroup_content">
                        <div class="listMenuGroup_content_title">
                            <div>Quỹ đầu tư</div>
                            <div class="listMenuGroup_content_title_tag">mới</div>
                        </div>
                        <div class="listMenuGroup_content_description">Các quỹ đầu tư uy tín, hỗ trợ khởi nghiệp và thúc đẩy tăng trưởng bền vững</div>
                    </div>
                </a>
            </li>
        </ul>

    </div>
</div>