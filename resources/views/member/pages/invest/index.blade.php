 @extends('member.layouts.app')
 @section('content')
     <!-- Scrollable Content Area -->
     <div class="scrollable-content">
         <div class="content-section">
             {{-- <h5 class="text-white mb-3">Invest</h5> --}}

             <!-- Example Card 1 -->
             <div class="card-dark shadow-sm p-3 mb-3">
                 <h6 class="text-white mb-2">Card Title</h6>
                 <p class="small text-muted mb-0">
                     Ini adalah contoh card dengan styling yang konsisten. Anda bisa menambahkan konten apapun di
                     sini.
                 </p>
             </div>

             <!-- Example Card 2 with Button -->
             <div class="card-dark shadow-sm p-3 mb-3">
                 <h6 class="text-white mb-2">Action Card</h6>
                 <p class="small text-muted mb-3">
                     Card ini memiliki tombol untuk aksi tertentu.
                 </p>
                 <button class="btn btn-gold w-100">
                     <i class="bi bi-check-circle me-2"></i>Lakukan Aksi
                 </button>
             </div>

             <!-- Example List -->
             <div class="card-dark shadow-sm p-0 mb-3">
                 <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                     <h6 class="text-white mb-0">Daftar Item</h6>
                 </div>
                 <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                     <div class="d-flex justify-content-between align-items-center">
                         <div>
                             <div class="text-white fw-bold" style="font-size: 14px;">Item 1</div>
                             <small class="text-muted">Deskripsi item pertama</small>
                         </div>
                         <span class="text-gold fw-bold">Rp 100.000</span>
                     </div>
                 </div>
                 <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                     <div class="d-flex justify-content-between align-items-center">
                         <div>
                             <div class="text-white fw-bold" style="font-size: 14px;">Item 2</div>
                             <small class="text-muted">Deskripsi item kedua</small>
                         </div>
                         <span class="text-gold fw-bold">Rp 200.000</span>
                     </div>
                 </div>
                 <div class="p-3">
                     <div class="d-flex justify-content-between align-items-center">
                         <div>
                             <div class="text-white fw-bold" style="font-size: 14px;">Item 3</div>
                             <small class="text-muted">Deskripsi item ketiga</small>
                         </div>
                         <span class="text-gold fw-bold">Rp 300.000</span>
                     </div>
                 </div>
             </div>

             <!-- Extra content for scrolling demo -->
             <div class="card-dark shadow-sm p-3 mb-3">
                 <h6 class="text-white mb-2">More Content</h6>
                 <p class="small text-muted mb-0">
                     Scroll ke bawah untuk melihat lebih banyak konten. Header dan bottom nav akan tetap di tempat.
                 </p>
             </div>
         </div>
     </div>
 @endsection
