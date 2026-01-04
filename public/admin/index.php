<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="min-h-screen bg-white text-black">
    <header class="bg-black text-white">
      <div class="max-w-4xl mx-auto px-6 py-4">
        <h1 class="text-lg font-semibold">Admin Dashboard</h1>
      </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-10">
      <nav class="grid sm:flex sm:gap-6 gap-3">
        <a href="profile.html" class="px-4 py-2 bg-black text-white rounded shadow-sm hover:opacity-90">Edit Profile</a>
        <a href="skills.html" class="px-4 py-2 border border-gray-200 rounded hover:bg-gray-50">Manage Skills</a>
        <a href="projects.html" class="px-4 py-2 border border-gray-200 rounded hover:bg-gray-50">Manage Projects</a>
        <a href="certifications.html" class="px-4 py-2 border border-gray-200 rounded hover:bg-gray-50">Manage Certifications</a>
      </nav>
    </main>
  </div>
</body>
</html>
