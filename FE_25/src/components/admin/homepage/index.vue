<template>
   <div class="container">
      <div class="row">
         <!-- CỘT TRÁI: KHUNG CHAT AI (Đã sửa lại cấu trúc để tránh lỗi CSS) -->
         <div class="col-lg-4 mb-3 mb-lg-0">
            <div id="ai-chat-widget">

               <!-- HEADER -->
               <div class="chat-widget-header">
                  <div class="header-content">
                     <div class="avatar-circle">
                        <i class="fas fa-robot"></i>
                     </div>
                     <div class="header-info">
                        <div class="title">AI Stylist</div>
                        <span class="status-badge">Online</span>
                     </div>
                  </div>
                  <div class="header-actions">
                     <i class="fas fa-ellipsis-v"></i>
                  </div>
               </div>

               <!-- BODY -->
               <div class="chat-widget-body" ref="chatBody">
                  <div v-for="(msg, index) in messages" :key="index"
                     :class="['chat-row', msg.sender === 'user' ? 'row-user' : 'row-bot']">

                     <div class="chat-bubble">
                        <div v-html="msg.text"></div>

                        <!-- Sản phẩm gợi ý -->
                        <div v-if="msg.products && msg.products.length > 0" class="product-list">
                           <small>Gợi ý cho bạn:</small>
                           <div v-for="prod in msg.products" :key="prod.id" class="product-item">
                              <img :src="prod.hinh_anh" alt="sp">
                              <div class="product-info">
                                 <div class="product-name">{{ prod.ten_san_pham }}</div>
                                 <div class="product-price">{{ formatPrice(prod.gia_ban) }}</div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="chat-time">{{ msg.time }}</div>
                  </div>

                  <!-- Typing indicator -->
                  <div v-if="isTyping" class="chat-row row-bot">
                     <div class="typing-bubble">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                     </div>
                  </div>
               </div>

               <!-- FOOTER -->
               <div class="chat-widget-footer">
                  <div class="input-container">
                     <input type="text" v-model="userInput" @keyup.enter="sendMessage"
                        placeholder="Nhập chiều cao, cân nặng...">
                     <button @click="sendMessage">
                        <i class="fas fa-paper-plane"></i>
                     </button>
                  </div>
               </div>

            </div>
         </div>

         <!-- CỘT PHẢI: CAROUSEL (GIỮ NGUYÊN) -->
         <div class="col-lg-8">
            <div id="carouselExampleDark" ref="myCarousel" class="carousel carousel-dark slide rounded-3 overflow-hidden shadow-sm" data-bs-ride="carousel">
               <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0"
                     class="active"></button>
                  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"></button>
                  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"></button>
               </div>
               <div class="carousel-inner">
                  <div class="carousel-item active" data-bs-interval="3000">
                     <img
                        src="https://dongphuccati.com/upload_images/images/bai%20thang%206/hot%20trend%202021/dark-wear.jpg"
                        class="d-block w-100 carousel-img">
                     <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-2 rounded">
                        <h5 class="text-white">Sản phẩm HOT</h5>
                        <p class="text-white">Bộ sưu tập mới nhất mùa này</p>
                     </div>
                  </div>
                  <div class="carousel-item" data-bs-interval="2000">
                     <img src="https://pos.nvncdn.com/7d27de-65076/bn/20251118_dyanSFVy.webp?v=1763461102"
                        class="d-block w-100 carousel-img">
                     <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-2 rounded">
                        <h5 class="text-white">Khuyến mãi lớn</h5>
                        <p class="text-white">Giảm giá lên đến 50%</p>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <img src="https://cdn.santino.com.vn/storage/upload/news/2023/09/thoi-trang-nam-cao-cap.webp"
                        class="d-block w-100 carousel-img">
                     <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-2 rounded">
                        <h5 class="text-white">Thời trang cao cấp</h5>
                        <p class="text-white">Đẳng cấp phái mạnh</p>
                     </div>
                  </div>
               </div>
               <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                  data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               </button>
               <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                  data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
               </button>
            </div>
         </div>
      </div>
   </div>
   <br>

   <!-- DANH SÁCH SẢN PHẨM -->
   <div class="row row-cols-1 row-cols-lg-4 g-2 g-lg-3">
      <div class="col-lg-3" v-for="(product, index) in products" :key="index">
         <div class="card h-100 shadow-sm border-0">
            <img :src="product.hinh_anh" class="card-img-top">
            <div class="card-body">
               <h5 class="card-title text-truncate">{{ product.ten_san_pham }}</h5>
               <p class="card-text text-truncate small text-muted">{{ product.mo_ta }}</p>
               <div class="d-flex justify-content-between align-items-center mt-3">
                  <button class="btn btn-outline-primary btn-sm">Chi tiết</button>
                  <span class="fw-bold text-primary">{{ formatPrice(product.gia_ban) }}</span>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- FOOTER PAGE -->
   <div class="row">
      <footer style="background-color:whitesmoke; padding: 40px; color: black;" class="mt-4">
         <div class="container ">
            <div class="row">
               <div class="col-lg-4 col-md-6 mb-4">
                  <h4>ShopS5</h4>
                  <p class="mt-2">Mọi thắc mắc xin liên hệ</p>
                  <div><i class="fa-solid fa-arrow-turn-down mt-2"></i><span>01 Hà Huy Tâp,Đà Nẵng</span></div>
                  <div><i class="fa-regular fa-envelope me-2 mt-2"></i><span>SHOPS5@gmail.com</span></div>
                  <div><i class="fa-solid fa-phone me-2 mt-2"></i><span>+84-842091225</span></div>
               </div>
               <div class="col-lg-3 col-md-6 mb-4 mt-3">
                  <div>
                     <i class="fa-solid fa-angle-right"></i><a href="#">Trang Chủ</a><br>
                     <i class="fa-solid fa-angle-right"></i><a href="#">Sản Phẩm</a><br>
                     <i class="fa-solid fa-angle-right"></i><a href="#">Giỏ Hàng</a><br>
                     <i class="fa-solid fa-angle-right"></i><a href="#">Khách Hàng</a><br>
                     <i class="fa-solid fa-angle-right"></i><a href="#">Liên Hệ</a>
                  </div>
               </div>
               <div class="col-lg-5 col-md-6 mb-4">
                  <div class="row">
                     <div class="col-lg-8 mb-4">
                        <h5>Góp ý</h5>
                        <form>
                           <div class="mb-2">
                              <label class="form-label">Email của bạn</label>
                              <input type="email" class="form-control">
                           </div>
                           <div class="mb-2">
                              <label class="form-label">Góp ý của bạn</label>
                              <input type="password" class="form-control">
                           </div>
                           <button type="submit" class="btn btn-info">Gửi góp ý</button>
                        </form>
                     </div>
                     <div class="col-lg-4 text-md-end text-start mb-4">
                        <div class="fs-2  align-items-md-end flex-row">
                           <a href="#" class="text-dark mb-2 me-3 me-md-0"><i class="fab fa-facebook"></i></a>
                           <a href="#" class="text-dark mb-2 me-3 me-md-0"><i class="fab fa-instagram"></i></a>
                           <a href="#" class="text-dark"><i class="fab fa-youtube"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <hr class="my-4">
         <div class="row pb-4 align-items-center">
            <div class="col-md-6 text-center text-md-start">
               @<strong>SHOPS5</strong>. Đã đăng ký Bản quyền. Thiết kế bởi <strong>Nhóm 5</strong>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2">
               <i class="fab fa-cc-visa fs-3 mx-1 text-primary"></i>
               <i class="fab fa-cc-mastercard fs-3 mx-1 text-danger"></i>
               <i class="fab fa-cc-paypal fs-3 mx-1 text-primary"></i>
               <i class="fa-brands fa-cc-visa fs-3 mx-1"></i>
            </div>
         </div>
      </footer>
   </div>
</template>

<script>
export default {
   data() {
      return {
         userInput: "",
         isTyping: false,
         messages: [
            {
               sender: 'bot',
               text: 'Chào bạn! Mình là AI tư vấn.<br>Bạn muốn tìm đồ đi <b>du lịch</b>, đồ <b>mùa đông</b>, hay tư vấn <b>size</b> nào?',
               time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
            }
         ],
         products: [
            { id: 2, ten_san_pham: "ÁO SƠ MI NAM", mo_ta: "Vải cotton thoáng mát", gia_ban: 350000, danh_muc: "ao_so_mi", hinh_anh: "https://images.unsplash.com/photo-1620012253295-c15cc3e65df4?q=80&w=1965&auto=format&fit=crop" },
            { id: 3, ten_san_pham: "QUẦN JEANS", mo_ta: "Phong cách năng động", gia_ban: 550000, danh_muc: "quan_jeans", hinh_anh: "https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1887&auto=format&fit=crop" },
            { id: 4, ten_san_pham: "ÁO VEST", mo_ta: "Lịch lãm sang trọng", gia_ban: 1500000, danh_muc: "vest", hinh_anh: "https://images.unsplash.com/photo-1594938298603-c8148c4dae35?q=80&w=1780&auto=format&fit=crop" },
            { id: 5, ten_san_pham: "ÁO THUN BASIC", mo_ta: "Đơn giản, dễ phối đồ", gia_ban: 150000, danh_muc: "ao_thun", hinh_anh: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1780&auto=format&fit=crop" },
            { id: 6, ten_san_pham: "ÁO KHOÁC BOMBER", mo_ta: "Chất dù 2 lớp, ấm áp", gia_ban: 450000, danh_muc: "ao_khoac", hinh_anh: "https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop" },
            { id: 7, ten_san_pham: "GIÀY SNEAKER", mo_ta: "Trắng basic, êm chân", gia_ban: 650000, danh_muc: "giay", hinh_anh: "https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=2012&auto=format&fit=crop" },
            { id: 8, ten_san_pham: "QUẦN SHORT KAKI", mo_ta: "Mặc đi chơi, thoải mái", gia_ban: 250000, danh_muc: "quan_short", hinh_anh: "https://images.unsplash.com/photo-1591195853828-11db59a44f6b?q=80&w=2070&auto=format&fit=crop" },
            { id: 9, ten_san_pham: "ÁO POLO NAM", mo_ta: "Lịch sự, trẻ trung", gia_ban: 280000, danh_muc: "ao_thun", hinh_anh: "https://images.unsplash.com/photo-1626557981101-aae6f84aa6ff?q=80&w=2070&auto=format&fit=crop" },
            { id: 10, ten_san_pham: "QUẦN JOGGER KAKI", mo_ta: "Bo gấu, phong cách thể thao", gia_ban: 320000, danh_muc: "quan_dai", hinh_anh: "https://images.unsplash.com/photo-1552902865-b72c031ac5ea?q=80&w=1889&auto=format&fit=crop" },
            { id: 11, ten_san_pham: "BALO LAPTOP", mo_ta: "Chống nước, ngăn chống sốc", gia_ban: 550000, danh_muc: "phu_kien", hinh_anh: "https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=1887&auto=format&fit=crop" },
            { id: 12, ten_san_pham: "NÓN KẾT THỜI TRANG", mo_ta: "Vải kaki, logo thêu nổi", gia_ban: 120000, danh_muc: "phu_kien", hinh_anh: "https://images.unsplash.com/photo-1588850561407-ed78c282e89b?q=80&w=1935&auto=format&fit=crop" },
            { id: 13, ten_san_pham: "KÍNH MÁT AVIATOR", mo_ta: "Chống tia UV, gọng kim loại", gia_ban: 350000, danh_muc: "phu_kien", hinh_anh: "https://images.unsplash.com/photo-1572635196237-14b3f281503f?q=80&w=2080&auto=format&fit=crop" },
            { id: 14, ten_san_pham: "THẮT LƯNG DA BÒ", mo_ta: "Da thật 100%, mặt khóa tự động", gia_ban: 450000, danh_muc: "phu_kien", hinh_anh: "https://images.unsplash.com/photo-1624222247344-550fb60583dc?q=80&w=2070&auto=format&fit=crop" },
            { id: 15, ten_san_pham: "ĐỒNG HỒ THỂ THAO", mo_ta: "Chống nước, dây cao su bền", gia_ban: 950000, danh_muc: "phu_kien", hinh_anh: "https://images.unsplash.com/photo-1524592094714-0f0654e20314?q=80&w=1999&auto=format&fit=crop" },
            { id: 16, ten_san_pham: "ÁO HOODIE FORM RỘNG", mo_ta: "Phong cách street style", gia_ban: 420000, danh_muc: "ao_khoac", hinh_anh: "https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=1887&auto=format&fit=crop" },
            { id: 17, ten_san_pham: "ÁO BLAZER HÀN QUỐC", mo_ta: "Khoác nhẹ, trẻ trung", gia_ban: 850000, danh_muc: "vest", hinh_anh: "https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=2071&auto=format&fit=crop" },
            { id: 18, ten_san_pham: "GIÀY TÂY DA BÓNG", mo_ta: "Da bò thật, đế cao su đúc", gia_ban: 1200000, danh_muc: "giay", hinh_anh: "https://images.unsplash.com/photo-1614252369475-531eba835eb1?q=80&w=2070&auto=format&fit=crop" },
            { id: 19, ten_san_pham: "QUẦN TÂY CÔNG SỞ", mo_ta: "Vải âu cao cấp, không nhăn", gia_ban: 450000, danh_muc: "quan_dai", hinh_anh: "https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?q=80&w=1897&auto=format&fit=crop" },
            { id: 20, ten_san_pham: "TÚI ĐEO CHÉO", mo_ta: "Vải canvas, nhỏ gọn", gia_ban: 190000, danh_muc: "phu_kien", hinh_anh: "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=2069&auto=format&fit=crop" }
         ]
      };
   },
   mounted() {
        const carouselEl = document.getElementById('carouselExampleDark');
        if (carouselEl) {
            try {
                const carousel = new bootstrap.Carousel(carouselEl, {
                    interval: 3000,
                    ride: 'carousel'
                });
                carousel.cycle();
            } catch (e) {
                if (window.bootstrap) {
                    const carousel = new window.bootstrap.Carousel(carouselEl, {
                        interval: 3000,
                        ride: 'carousel'
                    });
                    carousel.cycle();
                }
            }
        }
    },
   methods: {
      formatPrice(value) {
         return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
      },
      scrollToBottom() {
         this.$nextTick(() => {
            const container = this.$refs.chatBody;
            if (container) container.scrollTop = container.scrollHeight;
         });
      },
      sendMessage() {
         if (!this.userInput.trim()) return;

         const text = this.userInput;
         const now = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
         this.messages.push({ sender: 'user', text: text, time: now });
         this.userInput = "";
         this.scrollToBottom();
         this.isTyping = true;

         setTimeout(() => {
            let replyText = "";
            let suggestedProducts = [];
            const lowerText = text.toLowerCase();
            const weightMatch = lowerText.match(/(\d+)\s*kg/);

            // --- 1. LOGIC TƯ VẤN CÂN NẶNG ---
            if (weightMatch) {
               const weight = parseInt(weightMatch[1]);
               let size = "";
               if (weight < 53) size = "S";
               else if (weight >= 53 && weight < 63) size = "M";
               else if (weight >= 63 && weight < 73) size = "L";
               else if (weight >= 73 && weight < 83) size = "XL";
               else size = "XXL";

               replyText = `Với cân nặng <b>${weight}kg</b>, AI khuyên bạn nên chọn size <b>${size}</b> nhé!`;
            }

            // --- 2. LOGIC TƯ VẤN NGỮ CẢNH (MỚI THÊM) ---
            // Ưu tiên check ngữ cảnh trước khi check sản phẩm cụ thể
            else if (lowerText.includes("du lịch") || lowerText.includes("biển") || lowerText.includes("đi chơi")) {
               replyText = "Đi du lịch thì ưu tiên sự thoải mái, năng động. Bạn có thể tham khảo combo <b>Áo thun + Quần Short + Phụ kiện</b> này nhé:";
               // Lấy ngẫu nhiên 1 áo thun, 1 quần short, 1 phụ kiện
               suggestedProducts = [
                  this.products.find(p => p.danh_muc === 'ao_thun'),
                  this.products.find(p => p.danh_muc === 'quan_short'),
                  this.products.find(p => p.danh_muc === 'phu_kien' && (p.ten_san_pham.includes('NÓN') || p.ten_san_pham.includes('KÍNH')))
               ].filter(Boolean);
            }
            else if (lowerText.includes("đông") || lowerText.includes("lạnh") || lowerText.includes("ấm")) {
               replyText = "Trời lạnh thì cứ <b>Hoodie</b> hoặc <b>Bomber</b> phối với <b>Quần Jeans</b> là chuẩn bài, vừa ấm vừa ngầu:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'ao_khoac' || p.danh_muc === 'quan_jeans');
            }
            else if (lowerText.includes("hè") || lowerText.includes("nóng") || lowerText.includes("mát")) {
               replyText = "Mùa hè nóng nực thì cứ <b>Áo thun/Polo</b> và <b>Quần Short</b> là chân ái ạ:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'ao_thun' || p.danh_muc === 'quan_short');
            }
            else if (lowerText.includes("công sở") || lowerText.includes("đi làm") || lowerText.includes("văn phòng")) {
               replyText = "Đi làm cần sự chỉn chu, mình gợi ý set <b>Sơ mi + Quần Tây</b> hoặc khoác thêm <b>Blazer</b> nhé:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'ao_so_mi' || p.danh_muc === 'quan_dai' || p.danh_muc === 'vest');
            }
            else if (lowerText.includes("tiệc") || lowerText.includes("cưới") || lowerText.includes("sang trọng")) {
               replyText = "Đi tiệc thì không thể thiếu bộ <b>Vest</b> lịch lãm hoặc <b>Giày Tây</b> sang trọng:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'vest' || (p.danh_muc === 'giay' && p.ten_san_pham.includes('TÂY')));
            }
            
            // --- 3. LOGIC TÌM SẢN PHẨM CỤ THỂ (Như cũ) ---
            else if (lowerText.includes("áo")) {
               if (lowerText.includes("sơ mi")) {
                  replyText = "Bên mình có mẫu Áo Sơ Mi rất đẹp cho công sở này:";
                  suggestedProducts = this.products.filter(p => p.danh_muc === 'ao_so_mi');
               } else if (lowerText.includes("thun") || lowerText.includes("phông") || lowerText.includes("polo")) {
                  replyText = "Áo thun và Polo basic, dễ phối đồ:";
                  suggestedProducts = this.products.filter(p => p.danh_muc === 'ao_thun');
               } else if (lowerText.includes("khoác") || lowerText.includes("hoodie") || lowerText.includes("bomber")) {
                  replyText = "Các mẫu áo khoác hot trend đây ạ:";
                  suggestedProducts = this.products.filter(p => p.danh_muc === 'ao_khoac');
               } else if (lowerText.includes("vest") || lowerText.includes("blazer")) {
                  replyText = "Vest và Blazer lịch lãm cho các quý ông:";
                  suggestedProducts = this.products.filter(p => p.danh_muc === 'vest');
               } else {
                  replyText = "Shop có nhiều loại áo lắm ạ: Sơ mi, Thun, Polo, Vest... Bạn muốn xem loại nào?";
                  suggestedProducts = this.products.filter(p => p.danh_muc.includes('ao')).slice(0, 4);
               }
            }
            else if (lowerText.includes("quần")) {
                if (lowerText.includes("jeans") || lowerText.includes("bò")) {
                   replyText = "Mẫu quần Jeans form chuẩn:";
                   suggestedProducts = this.products.filter(p => p.danh_muc === 'quan_jeans');
                } else if (lowerText.includes("short") || lowerText.includes("đùi") || lowerText.includes("ngắn")) {
                   replyText = "Quần Short mặc đi chơi cho mát:";
                   suggestedProducts = this.products.filter(p => p.danh_muc === 'quan_short');
                } else if (lowerText.includes("tây") || lowerText.includes("âu") || lowerText.includes("jogger")) {
                   replyText = "Các mẫu quần dài (Tây, Jogger) đây ạ:";
                   suggestedProducts = this.products.filter(p => p.danh_muc === 'quan_dai');
                } else {
                   replyText = "Bạn tìm quần dài, quần jeans hay quần short ạ? Mình có đủ cả:";
                   suggestedProducts = this.products.filter(p => p.danh_muc.includes('quan')).slice(0, 4);
                }
            }
            else if (lowerText.includes("mũ") || lowerText.includes("nón")) {
               replyText = "Nón kết thời trang, chất liệu Kaki xịn xò, đội là ngầu:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'phu_kien' && p.ten_san_pham.toLowerCase().includes("nón"));
            }
            else if (lowerText.includes("đồng hồ")) {
               replyText = "Mẫu Đồng hồ thể thao này đang rất hot, chống nước cực tốt:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'phu_kien' && p.ten_san_pham.toLowerCase().includes("đồng hồ"));
            }
            else if (lowerText.includes("giày") || lowerText.includes("sneaker")) {
               replyText = "Giày Sneaker và Giày Tây cho bạn lựa chọn:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'giay');
            }
            else if (lowerText.includes("phụ kiện") || lowerText.includes("balo") || lowerText.includes("kính") || lowerText.includes("thắt lưng")) {
               replyText = "Các món phụ kiện để hoàn thiện outfit:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'phu_kien');
            }

            else if (lowerText.includes("ship") || lowerText.includes("giao")) {
               replyText = "Phí ship đồng giá 30k toàn quốc. <b>Freeship</b> đơn từ 500k ạ!";
            }
            else if (lowerText.includes("địa chỉ") || lowerText.includes("shop")) {
               replyText = "Shop ở <b>01 Hà Huy Tập, Đà Nẵng</b>. Ghé chơi nhé!";
            }
            else {
               replyText = "Mình chưa hiểu rõ lắm. Bạn thử hỏi: 'đi du lịch mặc gì', 'áo thun', 'quần jeans' hoặc 'tư vấn size 60kg' xem sao?";
            }

            this.messages.push({ sender: 'bot', text: replyText, products: suggestedProducts, time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) });
            this.isTyping = false;
            this.scrollToBottom();
         }, 1200);
      }
   }
}
</script>
<style scoped>
#ai-chat-widget {
   width: 100%;
   height: 500px;
   background-color: #fff;
   border-radius: 12px;
   box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
   display: flex;
   flex-direction: column;
   overflow: hidden;
   position: relative;
   border: 1px solid #e0e0e0;
}

/* HEADER */
#ai-chat-widget .chat-widget-header {
   height: 60px;
   min-height: 60px;
   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
   color: white !important;
   display: flex;
   align-items: center;
   justify-content: space-between;
   padding: 0 15px;
   width: 100%;
   box-sizing: border-box;
   flex-shrink: 0;
}

#ai-chat-widget .header-content {
   display: flex;
   align-items: center;
   gap: 10px;
}

#ai-chat-widget .avatar-circle {
   width: 36px;
   height: 36px;
   background: rgba(255, 255, 255, 0.2);
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
}

#ai-chat-widget .header-info .title {
   font-weight: bold;
   font-size: 15px;
   line-height: 1.2;
}

#ai-chat-widget .status-badge {
   font-size: 11px;
   background-color: #28a745;
   padding: 1px 6px;
   border-radius: 10px;
   color: white;
}

/* BODY */
#ai-chat-widget .chat-widget-body {
   flex: 1;
   background-color: #f5f7fb;
   padding: 15px;
   overflow-y: auto;
   overflow-x: hidden;
   display: flex;
   flex-direction: column;
   gap: 15px; 
   min-height: 0;
}

/* Chat Rows */
#ai-chat-widget .chat-row {
   display: flex;
   flex-direction: column;
   max-width: 92%; 
   margin-bottom: 0; /* Đã dùng gap ở trên */
}

#ai-chat-widget .row-bot {
   align-self: flex-start;
}

#ai-chat-widget .row-user {
   align-self: flex-end;
   align-items: flex-end;
}

/* Chat Bubbles */
#ai-chat-widget .chat-bubble {
   padding: 12px 16px;
   border-radius: 12px;
   font-size: 14px;
   line-height: 1.5;
   word-wrap: break-word;
   box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
   width: 100%;
   box-sizing: border-box;
}

#ai-chat-widget .row-bot .chat-bubble {
   background-color: white;
   color: #333;
   border-bottom-left-radius: 2px;
}

#ai-chat-widget .row-user .chat-bubble {
   background-color: #007bff;
   color: white;
   border-bottom-right-radius: 2px;
}

#ai-chat-widget .chat-time {
   font-size: 10px;
   color: #999;
   margin-top: 4px;
}

/* Product List Container */
#ai-chat-widget .product-list {
   margin-top: 10px;
   padding-top: 8px;
   border-top: 1px solid #eee;
   width: 100%;
   box-sizing: border-box;
   display: flex;
   flex-direction: column;
   gap: 10px;
   max-height: 250px;
   overflow-y: auto;
}

/* Từng sản phẩm */
#ai-chat-widget .product-item {
   display: flex;
   align-items: center;
   background: #f8f9fa;
   padding: 10px;
   border-radius: 8px;
   border: 1px solid #eee;
   width: 100%;
   box-sizing: border-box;
   min-height: 60px;
   margin-top: 0; 
}

#ai-chat-widget .product-item:hover {
   background: #e9ecef;
}

#ai-chat-widget .product-item img {
   width: 50px;
   height: 50px;
   object-fit: cover;
   border-radius: 6px;
   margin-right: 12px;
   flex-shrink: 0;
}

#ai-chat-widget .product-info {
   flex: 1;
   min-width: 0;
   display: flex;
   flex-direction: column;
   justify-content: center;
}

/* Tên sản phẩm: Cho phép xuống dòng */
#ai-chat-widget .product-name {
   font-size: 13px;
   font-weight: 600;
   color: #333;
   margin-bottom: 4px;
   /* Cho phép xuống dòng thoải mái, không dùng line-clamp */
   white-space: normal;
   line-height: 1.3;
}

#ai-chat-widget .product-price {
   font-size: 13px;
   color: #dc3545;
   font-weight: bold;
}

/* FOOTER */
#ai-chat-widget .chat-widget-footer {
   padding: 10px;
   background-color: white;
   border-top: 1px solid #eee;
   min-height: 60px;
   box-sizing: border-box;
   width: 100%;
   flex-shrink: 0;
}

#ai-chat-widget .input-container {
   display: flex;
   align-items: center;
   background-color: #f0f2f5;
   border-radius: 25px;
   padding: 5px 10px;
   width: 100%;
   box-sizing: border-box;
}

#ai-chat-widget .input-container input {
   flex: 1;
   width: auto !important;
   min-width: 0;
   border: none;
   background: transparent;
   padding: 8px;
   font-size: 14px;
   outline: none;
   color: #333;
}

#ai-chat-widget .input-container button {
   background: #007bff;
   color: white;
   border: none;
   width: 35px;
   height: 35px;
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   cursor: pointer;
   flex-shrink: 0;
   margin-left: 5px;
}

#ai-chat-widget .input-container button:hover {
   background: #0056b3;
}

/* Typing Dots */
.typing-bubble {
   background: #e4e6eb;
   padding: 8px 12px;
   border-radius: 12px;
   display: inline-flex;
   align-items: center;
   gap: 3px;
   width: fit-content;
}

.dot {
   width: 6px;
   height: 6px;
   background: #90949c;
   border-radius: 50%;
   animation: bounce 1.4s infinite ease-in-out;
}

.dot:nth-child(1) {
   animation-delay: -0.32s;
}

.dot:nth-child(2) {
   animation-delay: -0.16s;
}

@keyframes bounce {

   0%,
   80%,
   100% {
      transform: scale(0);
   }

   40% {
      transform: scale(1);
   }
}

/* Global styles */
.carousel-img {
   height: 500px;
   object-fit: cover;
   border-radius: 8px;
}

.card .card-img-top {
   height: 250px;
   object-fit: cover;
}
</style>