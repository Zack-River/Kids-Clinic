<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kids Clinic System') }}</title>

    <!-- Bootstrap 5 RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @stack('styles')
</head>
<body>
    @auth
        <!-- Sidebar -->
        <aside class="sidebar d-flex flex-column py-4" id="main-sidebar">
            <div class="px-4 mb-4 pb-4 border-bottom border-secondary position-relative">
                <!-- Close Button for Mobile -->
                <button class="btn btn-link text-light position-absolute top-0 end-0 mt-2 me-2 d-md-none p-1" id="close-sidebar-btn" style="text-decoration: none;">
                    <span class="material-symbols-outlined fs-3">close</span>
                </button>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-center">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile" class="rounded-circle shadow-sm" width="55" height="55" style="object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f1f5f9&color=64748b" alt="{{ Auth::user()->name }}" class="rounded-circle shadow-sm" width="55" height="55" style="border: 2px solid rgba(255,255,255,0.2);">
                        @endif
                    </div>
                    <div class="text-white">
                        <h6 class="mb-0 fw-bold">{{ Auth::user()->name }}</h6>
                        <small class="text-light opacity-75">{{ Auth::user()->role->name ?? 'مستخدم' }}</small>
                    </div>
                </div>
            </div>

            <nav class="px-2 flex-grow-1">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>الرئيسية</span>
                </a>
                <a href="{{ route('kids.index') }}" class="nav-link {{ request()->routeIs('kids.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">child_care</span>
                    <span>سجلات الأطفال</span>
                </a>
                <a href="{{ route('reservations.index') }}" class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">medical_services</span>
                    <span>الكشوفات الطبية</span>
                </a>
                <a href="{{ route('consultations.index') }}" class="nav-link {{ request()->routeIs('consultations.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">chat</span>
                    <span>الاستشارات</span>
                </a>
                <a href="{{ route('vaccines.index') }}" class="nav-link {{ request()->routeIs('vaccines.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">vaccines</span>
                    <span>التطعيمات</span>
                </a>
                <a href="{{ route('accounts.index') }}" class="nav-link {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                    <span>الحسابات</span>
                </a>
                @if(auth()->check() && auth()->user()->role && in_array(auth()->user()->role->name, ['Admin', 'Mod']))
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">group</span>
                    <span>المستخدمين</span>
                </a>
                @endif
            </nav>

            <div class="px-2 mt-auto pt-3 border-top border-secondary">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>الإعدادات</span>
                </a>
                <a href="{{ route('logout') }}" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="material-symbols-outlined">logout</span>
                    <span>تسجيل الخروج</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navbar -->
            <header class="topbar d-flex justify-content-between align-items-center px-2 px-md-4 sticky-top">
                <div class="d-flex align-items-center gap-1 gap-md-3">
                    <button class="btn btn-light d-md-none p-1" id="mobile-menu-btn">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="search-input-wrapper position-relative" id="global-search-container">
                        <span class="material-symbols-outlined">search</span>
                        <input type="text" id="global-search-input" class="form-control bg-light border-0" placeholder="بحث..." style="max-width: 140px;">
                        
                        <!-- Search Results Dropdown -->
                        <div id="global-search-results" class="position-absolute w-100 bg-white shadow-sm border rounded-3 mt-2 d-none overflow-hidden" style="top: 100%; right: 0; z-index: 1050; max-height: 400px; overflow-y: auto; min-width: 250px;">
                            <!-- Results injected here -->
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 gap-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-none d-sm-block text-end">
                            <div class="fw-bold mb-0 lh-1" style="font-size: 1.1rem;">
                                <span style="color: #0d6efd;">Kids</span> <span style="color: var(--primary-color);">Clinic</span>
                            </div>
                            <small style="color: #495057; font-size: 0.75rem; font-weight: 500;">Management System</small>
                        </div>
                        <img src="{{ asset('images/logo.png') }}" alt="Clinic Logo" height="40">
                    </div>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <div class="container-fluid p-4 flex-grow-1">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="bg-white border-top py-3 text-center text-muted mt-auto">
                <small>نظام إدارة عيادات الأطفال © 2025 الحقوق محفوظة</small>
            </footer>
        </main>
    @else
        <!-- Guest Content (Login) -->
        <main class="min-vh-100 d-flex flex-column justify-content-center py-5 bg-light">
            @yield('content')
        </main>
    @endauth

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle logic
            const sidebar = document.getElementById('main-sidebar');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const closeSidebarBtn = document.getElementById('close-sidebar-btn');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.add('show-sidebar');
                });
            }

            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', function() {
                    sidebar.classList.remove('show-sidebar');
                });
            }

            // Global Search Logic
            const searchInput = document.getElementById('global-search-input');
            const searchResults = document.getElementById('global-search-results');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();

                    if (query.length === 0) {
                        searchResults.classList.add('d-none');
                        searchResults.innerHTML = '';
                        return;
                    }

                    searchTimeout = setTimeout(() => {
                        fetch(`/global-search?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                searchResults.innerHTML = '';
                                
                                if (data.length === 0) {
                                    searchResults.innerHTML = `
                                        <div class="p-4 text-center text-muted small">
                                            <span class="material-symbols-outlined fs-2 mb-2 opacity-50 d-block">search_off</span>
                                            لا يوجد أطفال أو مستخدمين يطابقون بحثك.
                                        </div>
                                    `;
                                } else {
                                    let html = '<div class="list-group list-group-flush">';
                                    data.forEach(item => {
                                        html += `
                                            <a href="${item.url}" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 border-bottom text-decoration-none">
                                                <div class="bg-light rounded-circle p-2 d-flex align-items-center justify-content-center text-primary" style="width: 40px; height: 40px;">
                                                    <span class="material-symbols-outlined">${item.icon}</span>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0 lh-1">${item.name}</div>
                                                    <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">${item.type}</small>
                                                </div>
                                            </a>
                                        `;
                                    });
                                    html += '</div>';
                                    searchResults.innerHTML = html;
                                }
                                
                                searchResults.classList.remove('d-none');
                            })
                            .catch(error => console.error('Search error:', error));
                    }, 300); // 300ms debounce
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('d-none');
                    }
                });
                
                // Show dropdown again if input is focused and has value
                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length > 0 && searchResults.innerHTML !== '') {
                        searchResults.classList.remove('d-none');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
