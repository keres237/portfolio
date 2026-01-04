<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-slate-950 text-slate-100">
  <div id="app" class="min-h-screen flex flex-col"></div>
  
  <!-- Login Form Template -->
  <template id="loginTemplate">
    <div class="flex items-center justify-center min-h-screen bg-slate-950">
      <div class="w-full max-w-md p-8 border border-slate-700 rounded-lg bg-slate-900 shadow-2xl">
        <div class="flex justify-center mb-8">
          <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center">
            <span class="font-bold text-slate-950 text-xl">A</span>
          </div>
        </div>
        <h1 class="text-3xl font-bold mb-2 text-center text-white">Admin Login</h1>
        <p class="text-slate-400 text-center mb-8 text-sm">Enter your credentials to access the admin panel</p>
        
        <form id="loginForm" class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-300">Username</label>
            <input type="text" id="username" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500" placeholder="admin" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-300">Password</label>
            <input type="password" id="password" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500" placeholder="••••••••" required>
          </div>
          <button type="submit" class="w-full px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-semibold rounded transition">Login</button>
          <p id="errorMsg" class="text-red-400 text-sm text-center mt-2 min-h-5"></p>
        </form>
        
        <div class="mt-6 pt-6 border-t border-slate-700">
          <p class="text-slate-500 text-xs text-center">Demo credentials: admin / admin123</p>
        </div>
      </div>
    </div>
  </template>

  <!-- Dashboard Template -->
  <template id="dashboardTemplate">
    <header class="sticky top-0 z-50 border-b border-slate-800 bg-slate-950/95 backdrop-blur">
      <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center">
            <span class="font-bold text-slate-950 text-sm">A</span>
          </div>
          <h1 class="text-xl font-bold">Admin Dashboard</h1>
        </div>
        <div class="flex items-center gap-3">
          <a href="index.php" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded transition font-medium">← Back</a>
          <button id="logoutBtn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded transition font-medium">Logout</button>
        </div>
      </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto w-full px-6 py-8">
      <div class="flex gap-3 mb-8 flex-wrap">
        <button class="tab-btn px-4 py-2 border border-cyan-500 text-cyan-400 rounded active" data-tab="profile">Edit Profile</button>
        <button class="tab-btn px-4 py-2 border border-slate-700 text-slate-400 rounded hover:border-cyan-500" data-tab="skills">Manage Skills</button>
        <button class="tab-btn px-4 py-2 border border-slate-700 text-slate-400 rounded hover:border-cyan-500" data-tab="projects">Manage Projects</button>
      </div>

      <div id="tabContent"></div>
    </main>
  </template>

  <!-- Profile Form Template -->
  <template id="profileTemplate">
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 max-w-2xl">
      <h2 class="text-2xl font-bold mb-6">Edit Profile</h2>
      <form id="profileFormEl" class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-2">Profile Picture</label>
          <div class="flex items-center gap-4">
            <div id="imagePreview" class="w-24 h-24 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center overflow-hidden">
              <span class="text-slate-500 text-sm">No image</span>
            </div>
            <div class="flex-1">
              <input type="file" id="imageUpload" accept="image/*" class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-cyan-500 file:text-slate-950 hover:file:bg-cyan-600">
              <p class="text-xs text-slate-500 mt-1">or paste image URL below</p>
            </div>
          </div>
          <input type="text" id="profile_image" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white mt-3" placeholder="Image URL">
        </div>
        <div>
          <label class="block text-sm font-medium mb-2">Full Name</label>
          <input type="text" id="full_name" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white" required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-2">Title</label>
          <input type="text" id="title" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white" required>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-2">Email</label>
            <input type="email" id="email" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-2">Phone</label>
            <input type="text" id="phone" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white">
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium mb-2">Bio</label>
          <textarea id="bio" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white" rows="4"></textarea>
        </div>
        <div class="flex gap-3">
          <button type="submit" class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-semibold rounded transition">Save Changes</button>
          <button type="button" id="cancelBtn" class="px-6 py-2 bg-slate-700 hover:bg-slate-600 text-white font-semibold rounded transition">Cancel</button>
        </div>
        <p id="profileMsg" class="text-sm mt-2"></p>
      </form>
    </div>
  </template>

  <!-- Skills Template -->
  <template id="skillsTemplate">
    <div class="space-y-6">
      <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 max-w-2xl">
        <h3 class="text-xl font-bold mb-4">Add New Skill</h3>
        <form id="addSkillForm" class="space-y-4">
          <input type="text" id="skill_name" placeholder="Skill name" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-500" required>
          <input type="text" id="proficiency_level" placeholder="Proficiency (e.g., Expert, Intermediate)" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-500" required>
          <input type="text" id="category" placeholder="Category" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-500">
          <button type="submit" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-semibold rounded transition">Add Skill</button>
          <p id="skillMsg" class="text-sm mt-2 min-h-5"></p>
        </form>
      </div>
      <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
        <h3 class="text-xl font-bold mb-4">Skills List (<span id="skillCount">0</span>)</h3>
        <div id="skillsList" class="space-y-2"></div>
      </div>
    </div>
  </template>

  <!-- Projects Template -->
  <template id="projectsTemplate">
    <div class="space-y-6">
      <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 max-w-2xl">
        <h3 class="text-xl font-bold mb-4">Add New Project</h3>
        <form id="addProjectForm" class="space-y-4">
          <input type="text" id="proj_title" placeholder="Project title" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-500" required>
          <textarea id="proj_description" placeholder="Description" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-500" rows="3"></textarea>
          <input type="text" id="proj_tech_stack" placeholder="Tech stack (comma separated)" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-500">
          <input type="text" id="proj_link" placeholder="Project link" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-500">
          <button type="submit" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-semibold rounded transition">Add Project</button>
          <p id="projectMsg" class="text-sm mt-2 min-h-5"></p>
        </form>
      </div>
      <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
        <h3 class="text-xl font-bold mb-4">Projects List (<span id="projectCount">0</span>)</h3>
        <div id="projectsList" class="space-y-3"></div>
      </div>
    </div>
  </template>

  <script type="module" src="js/admin.js"></script>
</body>
</html>
