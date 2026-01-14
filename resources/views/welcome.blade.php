<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbz Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-indigo-600">Nexus Insight</h1>
            <ul class="flex space-x-6 text-gray-700">
                <li><a href="#" class="hover:text-indigo-600">Dashboard</a></li>
                <li><a href="#" class="hover:text-indigo-600">Blogs</a></li>
                <li><a href="#" class="hover:text-indigo-600">About</a></li>
                <li><a href="#" class="hover:text-indigo-600">Contact</a></li>
                <li><a href="#" class="hover:text-indigo-600 font-medium">Login</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-5xl font-bold mb-4">Welcome to Barbz Blog</h2>
            <p class="text-lg mb-6">Discover inspiring stories, tech tutorials, and lifestyle articles curated for you.</p>
            <a href="#blogs" class="bg-white text-indigo-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-200">Explore Blogs</a>
        </div>
    </section>

    <!-- Featured Blogs -->
    <section id="blogs" class="py-16 max-w-6xl mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12 text-gray-800">Featured Posts</h3>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Blog Card 1 -->
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition">
                <img src="https://source.unsplash.com/600x400/?writing" class="rounded-t-2xl w-full" alt="Blog Image">
                <div class="p-6">
                    <h4 class="text-xl font-semibold mb-2 text-indigo-600">The Art of Writing</h4>
                    <p class="text-gray-600 mb-4">Tips and insights for improving your writing and storytelling craft.</p>
                    <a href="#" class="text-indigo-600 font-medium hover:underline">Read More →</a>
                </div>
            </div>

            <!-- Blog Card 2 -->
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition">
                <img src="https://source.unsplash.com/600x400/?technology" class="rounded-t-2xl w-full" alt="Tech Blog">
                <div class="p-6">
                    <h4 class="text-xl font-semibold mb-2 text-indigo-600">Tech Trends 2025</h4>
                    <p class="text-gray-600 mb-4">A look at the top technologies shaping our world this year.</p>
                    <a href="#" class="text-indigo-600 font-medium hover:underline">Read More →</a>
                </div>
            </div>

            <!-- Blog Card 3 -->
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition">
                <img src="https://source.unsplash.com/600x400/?lifestyle" class="rounded-t-2xl w-full" alt="Lifestyle Blog">
                <div class="p-6">
                    <h4 class="text-xl font-semibold mb-2 text-indigo-600">Balanced Living</h4>
                    <p class="text-gray-600 mb-4">Practical advice for balancing work, health, and happiness.</p>
                    <a href="#" class="text-indigo-600 font-medium hover:underline">Read More →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center">
        <p>© 2025 Nexus Insight. All rights reserved.</p>
    </footer>

</body>
</html>
