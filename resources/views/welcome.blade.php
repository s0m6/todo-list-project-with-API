<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>مهامي - تطبيق إدارة المهام</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif !important;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900 antialiased">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-5 flex justify-between items-center">
            <a href="/" class="text-2xl font-semibold text-blue-600">
                مهامي
            </a>
            <div class="space-x-4 flex items-center">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/tasks') }}"
                    class="py-2 px-4 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                    لوحة التحكم
                </a>
                @else
                <a href="{{ route('login') }}"
                    class="py-2 px-4 text-gray-700 hover:text-blue-600 transition-colors duration-200">
                    تسجيل الدخول
                </a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center py-2 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-colors duration-200">
                    إنشاء حساب
                </a>
                @endif
                @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-50 py-24">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-blue-900 mb-8">
                نظّم مهامك، أنجز أكثر
            </h1>
            <p class="text-lg text-gray-700 leading-relaxed mb-12">
                تطبيق مهامي يساعدك على إدارة مهامك اليومية بكفاءة وسهولة. ابدأ اليوم وحقق أهدافك!
            </p>
            <a href="{{ route('register') }}"
                class="inline-flex items-center justify-center py-3 px-8 bg-blue-600 text-white rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-colors duration-200">
                ابدأ مجانًا
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 ml-2">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM8.547 9.505a.75.75 0 00-.69 1.19l3.22 4.028a.75.75 0 001.144 0l3.22-4.028a.75.75 0 00-.69-1.19H8.547z"
                        clip-rule="evenodd" />
                </svg>

            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Feature 1 -->
                <div
                    class="feature-card bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <i class='bx bx-list-plus text-3xl'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">إضافة المهام بسهولة</h3>
                    <p class="text-gray-600">أضف مهامك بسرعة وسهولة، مع تحديد الأولويات والمواعيد.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="feature-card bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <i class='bx bx-bar-chart-alt text-3xl'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">تتبع التقدم بفاعلية</h3>
                    <p class="text-gray-600">راقب تقدمك في إنجاز المهام وحافظ على إنتاجيتك العالية.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="feature-card bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <i class='bx bx-calendar-check text-3xl'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">إدارة الوقت بذكاء</h3>
                    <p class="text-gray-600">خطط ليومك وأسبوعك بكفاءة عالية لتحقيق أهدافك.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 py-8">
        <div class="container mx-auto px-6 text-center text-gray-600">
            <p>© 2025 مهامي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>
</body>

</html>