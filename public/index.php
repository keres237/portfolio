<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Portfolio</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Merriweather:ital@0;1&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased">
  <div class="min-h-screen flex flex-col">
    
    <header class="sticky top-0 z-50 border-b border-slate-800 bg-slate-950/95 backdrop-blur">
      <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center">
            <span class="font-bold text-slate-950 text-lg">MS</span>
          </div>
          <span class="text-xl font-semibold tracking-tight text-white">Mariane's Portfolio</span>
        </div>
        <nav class="hidden sm:flex items-center gap-8 text-sm font-medium">
          <a href="#profile-section" class="text-slate-400 hover:text-cyan-400 transition">Profile</a>
          <a href="#skills-section" class="text-slate-400 hover:text-cyan-400 transition">Skills</a>
          <a href="#projects-section" class="text-slate-400 hover:text-cyan-400 transition">Projects</a>
          <a href="admin.php" class="text-slate-400 hover:text-cyan-400 transition">Admin</a>
        </nav>
      </div>
    </header>
    

    <main class="flex-1 max-w-7xl mx-auto w-full px-6 py-20">
      <!-- HERO / PROFILE -->
      <section id="profile-section" class="mb-32">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
          <h2 id="profile-name" class="text-3xl md:text-5xl font-bold tracking-tight mb-4 text-white leading-tight">
            </h2>
            <p id="profile-title" class="text-2xl text-cyan-400 font-semibold mb-6"></p>
            <p id="profile-bio" class="text-lg text-slate-300 leading-relaxed mb-8 max-w-xl"></p>
            
            <div class="flex flex-col gap-4 text-sm">
              <div class="flex items-center gap-3">
                <span class="text-cyan-400 font-semibold">Email:</span>
                <span id="profile-email" class="text-slate-300"></span>
              </div>
              <div class="flex items-center gap-3">
                <span class="text-cyan-400 font-semibold">Phone:</span>
                <span id="profile-phone" class="text-slate-300"></span>
              </div>
            </div>

            <div class="flex gap-4 mt-8">
              <a href="#" class="px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-semibold rounded-lg transition">Get In Touch</a>
              <a href="#" class="px-6 py-3 border border-slate-700 hover:border-cyan-400 text-slate-300 hover:text-cyan-400 font-semibold rounded-lg transition">View CV</a>
            </div>
          </div>
          
          <div class="flex justify-center md:justify-end">
            <img id="profile-image" src="placeholder-user.jpg" alt="Profile Picture" class="w-64 h-64 md:w-80 md:h-80 rounded-2xl object-cover border-2 border-cyan-400/30 shadow-2xl">
          </div>
        </div>
      </section>

      <div class="h-px bg-gradient-to-r from-transparent via-slate-700 to-transparent mb-32"></div>

      <!-- SKILLS -->
      <section id="skills-section" class="mb-32">
        <h3 class="text-3xl md:text-4xl font-bold mb-12 text-white">Skills & Expertise</h3>
        <ul id="skills-list" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4"></ul>
      </section>

      <div class="h-px bg-gradient-to-r from-transparent via-slate-700 to-transparent mb-32"></div>

      <!-- PROJECTS -->
      <section id="projects-section" class="mb-32">
        <h3 class="text-3xl md:text-4xl font-bold mb-12 text-white">Featured Projects</h3>
        <div id="projects-container" class="grid grid-cols-1 md:grid-cols-2 gap-8"></div>
      </section>
    </main>

    <footer class="border-t border-slate-800 mt-12">
      <div class="max-w-7xl mx-auto px-6 py-12 text-center text-slate-500 text-sm">
        My Portfolio 2025
      </div>
    </footer>
  </div>

  <script type="module" src="js/main.js"></script>
</body>
</html>
