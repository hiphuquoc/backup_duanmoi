<!-- box danh sách dự án -->
<div class="bussinessPlanBox">
    @for($i=0;$i<10;++$i)
        <div class="bussinessPlanBox_item">
            <div class="bussinessPlanBox_item_detail">
                <div class="bussinessPlanBox_item_detail_logo">
                    <img src="https://cdn.wallsora.com/storage/images/favicon-wallsora.webp" alt="" title="" />
                </div>
                <div class="bussinessPlanBox_item_detail_text">
                    <a href="#" class="bussinessPlanBox_item_detail_text_title maxLine_2">
                        <h2>Wallsora - Dự án hình nền Premium với hệ thống CRM & affiliate hoàn chỉnh, 50 ngôn ngữ</h2>
                    </a>
                    <div class="bussinessPlanBox_item_detail_text_subTitle">
                        <div class="bussinessPlanBox_item_detail_text_subTitle_item">
                            <svg><use xlink:href="#icon_expland"></use></svg>
                            <div>Quy mô toàn cầu</div>
                        </div>
                        <div class="bussinessPlanBox_item_detail_text_subTitle_item">
                            <svg><use xlink:href="#icon_calendar_days"></use></svg>
                            <div>đăng 10/05/2025</div>
                        </div>
                        <div class="bussinessPlanBox_item_detail_text_subTitle_item">
                            <svg><use xlink:href="#icon_calendar_xmark"></use></svg>
                            <div>hết hạn 31/08/2025</div>
                        </div>
                    </div>
                    <div class="bussinessPlanBox_item_detail_text_desc maxLine_3">
                        Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
                    </div>
                    <div class="bussinessPlanBox_item_detail_text_footer">
                        <div class="bussinessPlanBox_item_detail_text_footer_tags">
                            <div class="bussinessPlanBox_item_detail_text_footer_tags_item">
                                Đang gọi vốn
                            </div>
                            <div class="bussinessPlanBox_item_detail_text_footer_tags_item">
                                Toàn cầu
                            </div>
                            <div class="bussinessPlanBox_item_detail_text_footer_tags_item">
                                Đã thẩm định
                            </div>
                            <div class="bussinessPlanBox_item_detail_text_footer_tags_item">
                                Tiềm năng cao
                            </div>
                        </div>
                        <a href="#" class="bussinessPlanBox_item_detail_text_footer_button">
                            Xem chi tiết
                        </a>
                    </div>
                    
                </div>
            </div>
            {{-- <div class="bussinessPlanBox_item_infoAndButton">
                <div class="bussinessPlanBox_item_infoAndButton_info">
                    <div class="bussinessPlanBox_item_infoAndButton_info_highLight">
                        18.52%
                    </div>
                    <div class="bussinessPlanBox_item_infoAndButton_info_sub">
                        cổ phần từ <span>0.5%</span>
                    </div>
                </div>
                <div class="bussinessPlanBox_item_infoAndButton_button">
                    Chi tiết
                </div>
            </div> --}}
        </div>
    @endfor
</div>