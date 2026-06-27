<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ config('app.name', 'Kids Clinic System') }} - تسجيل دخول</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "secondary-fixed-dim": "#b5c8df",
                        "outline": "#8d7164",
                        "tertiary-fixed-dim": "#61de8a",
                        "secondary-fixed": "#d1e4fb",
                        "on-surface-variant": "#594236",
                        "surface-container": "#ebeeed",
                        "on-tertiary-container": "#003c1b",
                        "inverse-surface": "#2d3131",
                        "surface-container-high": "#e6e9e8",
                        "on-secondary-fixed-variant": "#36485b",
                        "on-primary-fixed-variant": "#783100",
                        "tertiary-fixed": "#7efba4",
                        "on-error": "#ffffff",
                        "tertiary-container": "#2cb163",
                        "on-tertiary-fixed-variant": "#005228",
                        "primary-fixed": "#ffdbcb",
                        "on-tertiary-fixed": "#00210c",
                        "on-surface": "#181c1c",
                        "surface-bright": "#f7faf9",
                        "surface-tint": "#9e4300",
                        "on-secondary-fixed": "#091d2e",
                        "surface": "#f7faf9",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#592300",
                        "error-container": "#ffdad6",
                        "tertiary": "#006d37",
                        "surface-container-highest": "#e0e3e2",
                        "surface-variant": "#e0e3e2",
                        "surface-container-low": "#f1f4f3",
                        "background": "#f7faf9",
                        "on-primary": "#ffffff",
                        "on-background": "#181c1c",
                        "secondary-container": "#cfe2f9",
                        "surface-container-lowest": "#ffffff",
                        "on-error-container": "#93000a",
                        "surface-dim": "#d7dbda",
                        "on-secondary-container": "#526478",
                        "on-secondary": "#ffffff",
                        "primary-fixed-dim": "#ffb691",
                        "inverse-primary": "#ffb691",
                        "error": "#ba1a1a",
                        "primary-container": "#ff7000",
                        "primary": "#9e4300",
                        "outline-variant": "#e1c0b0",
                        "secondary": "#4e6073",
                        "on-primary-fixed": "#341100",
                        "inverse-on-surface": "#eef1f0"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline-md": ["Be Vietnam Pro"],
                        "body-lg": ["Be Vietnam Pro"],
                        "label-bold": ["Be Vietnam Pro"],
                        "headline-lg-mobile": ["Be Vietnam Pro"],
                        "headline-sm": ["Be Vietnam Pro"],
                        "body-md": ["Be Vietnam Pro"],
                        "display-lg": ["Be Vietnam Pro"],
                        "label-sm": ["Be Vietnam Pro"]
                    },
                    "fontSize": {
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "label-bold": ["12px", { "lineHeight": "16px", "letterSpacing": "0.5px", "fontWeight": "700" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "700" }],
                        "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "display-lg": ["32px", { "lineHeight": "40px", "fontWeight": "700" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "fontWeight": "500" }]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface h-screen flex items-center justify-center p-4 font-body-md text-on-surface">
    <div class="flex flex-col md:flex-row w-full max-w-5xl bg-surface-container-lowest shadow-md rounded-xl overflow-hidden min-h-[500px]">
        <!-- Branding Section -->
        <div class="hidden md:flex md:w-1/2 bg-primary-container p-8 flex-col items-center justify-center text-center">
            <h1 class="font-display-lg text-display-lg text-on-primary mb-2">نظام ادارة عيادة الاطفال</h1>
            <p class="font-body-lg text-body-lg text-on-primary mb-8 opacity-90">يساعدك على ادارة عيادتك</p>
            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm max-w-sm w-full flex items-center justify-center gap-6">
                <div class="text-right">
                    <div class="font-bold leading-tight mb-1 text-3xl">
                        <span style="color: #0d6efd;">Kids</span> <span style="color: #9e4300;">Clinic</span>
                    </div>
                    <div style="color: #495057;" class="text-base font-medium">Management System</div>
                </div>
                <img class="h-24 w-auto object-contain rounded-lg" alt="Clinic Logo" src="{{ asset('images/logo.png') }}"/>
            </div>
        </div>

        <!-- Login Form Section -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="max-w-md w-full mx-auto">
                <!-- Mobile Branding (Hidden on Desktop) -->
                <div class="md:hidden flex items-center justify-center gap-4 mb-8">
                    <div class="text-center">
                        <div class="font-bold leading-tight mb-1 text-2xl">
                            <span style="color: #0d6efd;">Kids</span> <span style="color: #9e4300;">Clinic</span>
                        </div>
                        <div style="color: #495057;" class="text-sm font-medium">Management System</div>
                    </div>
                    <img class="h-16 w-auto object-contain rounded-lg" alt="Clinic Logo" src="{{ asset('images/logo.png') }}"/>
                </div>

                <div class="text-center md:text-right mb-8">
                    <h2 class="font-display-lg text-display-lg text-on-surface mb-1">تسجيل دخول</h2>
                    <p class="font-body-md text-body-md text-secondary">الرجاء إدخال بياناتك للمتابعة</p>
                </div>

                <form class="space-y-4" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div>
                        <div class="flex flex-row-reverse border @error('username') border-error @else border-outline-variant @enderror rounded bg-surface-container-lowest overflow-hidden focus-within:border-primary-container transition-colors">
                            <div class="bg-surface-container-low p-3 flex items-center justify-center border-l border-outline-variant w-12 text-secondary">
                                <span class="material-symbols-outlined" data-icon="person">person</span>
                            </div>
                            <input class="w-full p-3 border-none focus:ring-0 text-right font-body-md text-on-surface placeholder-secondary-fixed-dim bg-transparent" placeholder="اسم المستخدم" required type="text" name="username" value="{{ old('username') }}" autocomplete="username" autofocus/>
                        </div>
                        @error('username')
                            <p class="text-error text-sm mt-1 text-right">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex flex-row-reverse border @error('password') border-error @else border-outline-variant @enderror rounded bg-surface-container-lowest overflow-hidden focus-within:border-primary-container transition-colors">
                            <div class="bg-surface-container-low p-3 flex items-center justify-center border-l border-outline-variant w-12 text-secondary">
                                <span class="material-symbols-outlined" data-icon="lock">lock</span>
                            </div>
                            <input class="w-full p-3 border-none focus:ring-0 text-right font-body-md text-on-surface placeholder-secondary-fixed-dim bg-transparent" placeholder="كلمة المرور" required type="password" name="password" autocomplete="current-password"/>
                        </div>
                        @error('password')
                            <p class="text-error text-sm mt-1 text-right">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6 flex flex-col items-center gap-4">
                        <button class="w-full justify-center bg-primary-container text-on-primary font-bold text-lg py-3 px-6 rounded-lg shadow-sm hover:bg-surface-tint transition-colors flex items-center gap-2" type="submit">
                            <span>دخول</span>
                            <span class="material-symbols-outlined text-xl" data-icon="login">login</span>
                        </button>
                        
                        <!-- Mobile Phrase (Hidden on Desktop) -->
                        <div class="md:hidden text-center mt-2">
                            <h3 class="font-bold text-on-surface mb-1">نظام ادارة عيادة الاطفال</h3>
                            <p class="text-secondary text-sm">يساعدك على ادارة عيادتك</p>
                        </div>

                        <small class="text-secondary opacity-75 font-medium mt-2">اسم المستخدم للتجربة: zackriver | الباسورد: password</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
