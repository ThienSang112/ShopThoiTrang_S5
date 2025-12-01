<template>
   <div class="container">
      <div class="row">
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
            <div id="carouselExampleDark" class="carousel carousel-dark slide rounded-3 overflow-hidden shadow-sm">
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
         <div class="container">
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
               @<strong>SHOPS5</strong>. Đã đăng ký Bản quyền. Thiết kế bởi <strong>Thanh Sáng</strong>
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
               text: 'Chào bạn! Mình là AI tư vấn. <br>Bạn cần tìm đồ đi đâu, hoặc nhập <b>chiều cao/cân nặng</b> để mình chọn size nhé?',
               time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
            }
         ],
         products: [
            { id: 2, ten_san_pham: "ÁO SƠ MI NAM", mo_ta: "Vải cotton thoáng mát", gia_ban: 350000, danh_muc: "ao_so_mi", hinh_anh: "https://bizweb.dktcdn.net/100/345/548/products/z4975375786651-c8bf932e5913c28da3b427a4fa35d4a1.jpg?v=1702574676273" },
            { id: 3, ten_san_pham: "QUẦN JEANS", mo_ta: "Phong cách năng động", gia_ban: 550000, danh_muc: "quan_jeans", hinh_anh: "https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1887&auto=format&fit=crop" },
            { id: 4, ten_san_pham: "ÁO VEST", mo_ta: "Lịch lãm sang trọng", gia_ban: 1500000, danh_muc: "vest", hinh_anh: "https://images.unsplash.com/photo-1594938298603-c8148c4dae35?q=80&w=1780&auto=format&fit=crop" },
            { id: 5, ten_san_pham: "ÁO THUN BASIC", mo_ta: "Đơn giản, dễ phối đồ", gia_ban: 150000, danh_muc: "ao_thun", hinh_anh: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1780&auto=format&fit=crop" }
         ]
      };
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

            if (weightMatch) {
               const weight = parseInt(weightMatch[1]);
               let size = "";

               // Cập nhật Logic Size (Thêm XL, XXL)
               if (weight < 53) size = "S";
               else if (weight >= 53 && weight < 63) size = "M";
               else if (weight >= 63 && weight < 73) size = "L";
               else if (weight >= 73 && weight < 83) size = "XL";
               else size = "XXL";

               replyText = `Với cân nặng <b>${weight}kg</b>, AI khuyên bạn nên chọn size <b>${size}</b> để mặc vừa vặn nhất nhé!`;

               // Gợi ý sản phẩm phù hợp (Bao gồm áo thun)
               if (lowerText.includes("áo")) {
                  suggestedProducts = this.products.filter(p => p.danh_muc === 'ao_so_mi' || p.danh_muc === 'vest' || p.danh_muc === 'ao_thun');
                  replyText += "<br>Mình gửi bạn tham khảo các mẫu áo (Sơ mi, Vest, Thun) đang hot:";
               }
            }
            else if (lowerText.includes("sơ mi")) {
               replyText = "Bên mình có mẫu Áo Sơ Mi rất đẹp cho công sở này:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'ao_so_mi');
            } else if (lowerText.includes("quần") || lowerText.includes("jeans")) {
               replyText = "Bạn xem thử mẫu quần Jeans này nhé:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'quan_jeans');
            } else if (lowerText.includes("thun") || lowerText.includes("phông")) {
               replyText = "Mẫu áo thun Basic này đang bán rất chạy, mặc thoải mái lắm ạ:";
               suggestedProducts = this.products.filter(p => p.danh_muc === 'ao_thun');
            } else if (lowerText.includes("size") || lowerText.includes("tư vấn")) {
               replyText = "Bạn cho mình xin chiều cao và cân nặng (ví dụ: 1m70, 75kg) để mình tính size chuẩn cho bạn nha.";
            } else {
               replyText = "Mình chưa hiểu rõ lắm. Bạn cần tìm <b>áo sơ mi</b>, <b>áo thun</b>, <b>quần jeans</b> hay cần <b>tư vấn size</b>?";
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
   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
   color: white;
   display: flex;
   align-items: center;
   justify-content: space-between;
   padding: 0 15px;
   width: 100%;
   box-sizing: border-box;
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
   display: flex;
   flex-direction: column;
   gap: 15px;
}

/* Chat Rows */
#ai-chat-widget .chat-row {
   display: flex;
   flex-direction: column;
   max-width: 85%;
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
   padding: 10px 14px;
   border-radius: 12px;
   font-size: 14px;
   line-height: 1.5;
   word-wrap: break-word;
   box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
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

/* Product List */
#ai-chat-widget .product-list {
   margin-top: 10px;
   padding-top: 8px;
   border-top: 1px solid #eee;
}

#ai-chat-widget .product-item {
   display: flex;
   align-items: center;
   background: #f8f9fa;
   padding: 6px;
   margin-top: 5px;
   border-radius: 6px;
   border: 1px solid #eee;
}

#ai-chat-widget .product-item img {
   width: 35px;
   height: 35px;
   object-fit: cover;
   border-radius: 4px;
   margin-right: 8px;
}

#ai-chat-widget .product-name {
   font-size: 12px;
   font-weight: 600;
   color: #333;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   max-width: 130px;
}

#ai-chat-widget .product-price {
   font-size: 11px;
   color: #dc3545;
   font-weight: bold;
}

/* FOOTER - INPUT AREA */
#ai-chat-widget .chat-widget-footer {
   padding: 10px;
   background-color: white;
   border-top: 1px solid #eee;
   min-height: 60px;
   box-sizing: border-box;
   width: 100%;
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
   /* Input tự co giãn */
   width: auto;
   /* Fix lỗi input bị đè */
   min-width: 0;
   /* Fix lỗi flexbox */
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