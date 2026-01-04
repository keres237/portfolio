import { login, logout, checkAuth } from "./api/auth.js"
import { getProfile, updateProfile } from "./api/profile.js"
import { getSkills, addSkill, deleteSkill } from "./api/skills.js"
import { getProjects, addProject, deleteProject } from "./api/projects.js"

let currentUser = null
let currentTab = "profile"
let profileData = null

document.addEventListener("DOMContentLoaded", async () => {
  const isLoggedIn = await checkAuth()
  if (isLoggedIn) {
    currentUser = "admin"
    renderDashboard()
  } else {
    renderLoginForm()
  }
})

function renderLoginForm() {
  const app = document.getElementById("app")
  const template = document.getElementById("loginTemplate")
  app.innerHTML = ""
  app.appendChild(template.content.cloneNode(true))

  document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault()
    const username = document.getElementById("username").value
    const password = document.getElementById("password").value
    const errorMsg = document.getElementById("errorMsg")

    const result = await login(username, password)
    if (result.logged_in) {
      currentUser = "admin"
      renderDashboard()
    } else {
      errorMsg.textContent = result.message || "Invalid credentials"
    }
  })
}

function renderDashboard() {
  const app = document.getElementById("app")
  const template = document.getElementById("dashboardTemplate")
  app.innerHTML = ""
  app.appendChild(template.content.cloneNode(true))

  // Tab switching
  document.querySelectorAll(".tab-btn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      document
        .querySelectorAll(".tab-btn")
        .forEach((b) => b.classList.remove("active", "border-cyan-500", "text-cyan-400"))
      e.target.classList.add("active", "border-cyan-500", "text-cyan-400")
      currentTab = e.target.dataset.tab
      renderTabContent()
    })
  })

  // Logout with confirmation
  document.getElementById("logoutBtn").addEventListener("click", async () => {
    if (confirm("Are you sure you want to logout?")) {
      await logout()
      renderLoginForm()
    }
  })

  renderTabContent()
}

async function renderTabContent() {
  const content = document.getElementById("tabContent")

  if (currentTab === "profile") {
    const template = document.getElementById("profileTemplate")
    content.innerHTML = ""
    content.appendChild(template.content.cloneNode(true))
    await renderProfileTab()
  } else if (currentTab === "skills") {
    const template = document.getElementById("skillsTemplate")
    content.innerHTML = ""
    content.appendChild(template.content.cloneNode(true))
    await renderSkillsTab()
  } else if (currentTab === "projects") {
    const template = document.getElementById("projectsTemplate")
    content.innerHTML = ""
    content.appendChild(template.content.cloneNode(true))
    await renderProjectsTab()
  }
}

async function renderProfileTab() {
  profileData = await getProfile(1)

  if (profileData?.profile_image) {
    document.getElementById("imagePreview").innerHTML =
      `<img src="${profileData.profile_image}" alt="Profile" class="w-full h-full object-cover">`
  }

  document.getElementById("full_name").value = profileData?.full_name || ""
  document.getElementById("title").value = profileData?.title || ""
  document.getElementById("email").value = profileData?.email || ""
  document.getElementById("phone").value = profileData?.phone || ""
  document.getElementById("bio").value = profileData?.bio || ""
  document.getElementById("profile_image").value = profileData?.profile_image || ""

  const imageUploadInput = document.getElementById("imageUpload")
  const profileImageInput = document.getElementById("profile_image")
  const imagePreview = document.getElementById("imagePreview")

  imageUploadInput.addEventListener("change", (e) => {
    const file = e.target.files[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (event) => {
        const base64 = event.target.result
        profileImageInput.value = base64
        imagePreview.innerHTML = `<img src="${base64}" alt="Profile" class="w-full h-full object-cover">`
      }
      reader.readAsDataURL(file)
    }
  })

  profileImageInput.addEventListener("change", (e) => {
    if (e.target.value) {
      imagePreview.innerHTML = `<img src="${e.target.value}" alt="Profile" class="w-full h-full object-cover">`
    }
  })

  document.getElementById("profileFormEl").addEventListener("submit", async (e) => {
    e.preventDefault()
    const updated = await updateProfile({
      id: 1,
      full_name: document.getElementById("full_name").value,
      title: document.getElementById("title").value,
      email: document.getElementById("email").value,
      phone: document.getElementById("phone").value,
      bio: document.getElementById("bio").value,
      profile_image: document.getElementById("profile_image").value,
    })
    const msg = document.getElementById("profileMsg")
    msg.textContent = updated.message || "Updated successfully!"
    msg.className = updated.status === "success" ? "text-green-400 text-sm mt-2" : "text-red-400 text-sm mt-2"
  })

  document.getElementById("cancelBtn").addEventListener("click", () => {
    document.getElementById("profileFormEl").reset()
    document.getElementById("full_name").value = profileData?.full_name || ""
    document.getElementById("title").value = profileData?.title || ""
    document.getElementById("email").value = profileData?.email || ""
    document.getElementById("phone").value = profileData?.phone || ""
    document.getElementById("bio").value = profileData?.bio || ""
    document.getElementById("profile_image").value = profileData?.profile_image || ""
    imagePreview.innerHTML = profileData?.profile_image
      ? `<img src="${profileData.profile_image}" alt="Profile" class="w-full h-full object-cover">`
      : `<span class="text-slate-500 text-sm">No image</span>`
  })
}

async function renderSkillsTab() {
  const skills = await getSkills()
  document.getElementById("skillCount").textContent = skills.length

  const skillsList = document.getElementById("skillsList")
  skillsList.innerHTML = ""

  if (skills.length === 0) {
    skillsList.innerHTML = `<p class="text-slate-400 text-sm">No skills added yet</p>`
  } else {
    skills.forEach((skill) => {
      const skillEl = document.createElement("div")
      skillEl.className = "flex justify-between items-center p-3 bg-slate-800 rounded hover:bg-slate-750 transition"
      skillEl.innerHTML = `
        <div>
          <p class="font-medium">${skill.skill_name}</p>
          <p class="text-sm text-slate-400">${skill.proficiency_level}</p>
        </div>
        <button class="delete-skill px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm" data-id="${skill.id}">Delete</button>
      `
      skillsList.appendChild(skillEl)
    })

    document.querySelectorAll(".delete-skill").forEach((btn) => {
      btn.addEventListener("click", async (e) => {
        const skillId = e.target.dataset.id
        if (confirm("Delete this skill?")) {
          await deleteSkill(skillId)
          renderSkillsTab()
        }
      })
    })
  }

  document.getElementById("addSkillForm").addEventListener("submit", async (e) => {
    e.preventDefault()
    const result = await addSkill({
      skill_name: document.getElementById("skill_name").value,
      proficiency_level: document.getElementById("proficiency_level").value,
      category: document.getElementById("category").value || "Technical",
    })
    document.getElementById("skillMsg").textContent = result.message || "Skill added!"
    document.getElementById("skillMsg").className =
      result.status === "success" ? "text-green-400 text-sm mt-2" : "text-red-400 text-sm mt-2"
    if (result.status === "success") {
      document.getElementById("addSkillForm").reset()
      setTimeout(() => renderSkillsTab(), 1000)
    }
  })
}

async function renderProjectsTab() {
  const projects = await getProjects()
  document.getElementById("projectCount").textContent = projects.length

  const projectsList = document.getElementById("projectsList")
  projectsList.innerHTML = ""

  if (projects.length === 0) {
    projectsList.innerHTML = `<p class="text-slate-400 text-sm">No projects added yet</p>`
  } else {
    projects.forEach((project) => {
      const projectEl = document.createElement("div")
      projectEl.className = "p-4 bg-slate-800 rounded hover:bg-slate-750 transition"
      projectEl.innerHTML = `
        <div class="flex justify-between items-start mb-2">
          <div class="flex-1">
            <p class="font-medium text-white">${project.title}</p>
            <p class="text-sm text-slate-400">${project.description || "No description"}</p>
            <p class="text-xs text-slate-500 mt-1">${project.tech_stack || "No tech stack"}</p>
            ${project.link ? `<a href="${project.link}" target="_blank" class="text-cyan-400 hover:text-cyan-300 text-sm inline-block mt-2">View Project →</a>` : ""}
          </div>
          <button class="delete-project px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm" data-id="${project.id}">Delete</button>
        </div>
      `
      projectsList.appendChild(projectEl)
    })

    document.querySelectorAll(".delete-project").forEach((btn) => {
      btn.addEventListener("click", async (e) => {
        const projectId = e.target.dataset.id
        if (confirm("Delete this project?")) {
          await deleteProject(projectId)
          renderProjectsTab()
        }
      })
    })
  }

  document.getElementById("addProjectForm").addEventListener("submit", async (e) => {
    e.preventDefault()
    const result = await addProject({
      title: document.getElementById("proj_title").value,
      description: document.getElementById("proj_description").value,
      tech_stack: document.getElementById("proj_tech_stack").value,
      link: document.getElementById("proj_link").value,
      project_date: new Date().toISOString().split("T")[0],
    })
    document.getElementById("projectMsg").textContent = result.message || "Project added!"
    document.getElementById("projectMsg").className =
      result.status === "success" ? "text-green-400 text-sm mt-2" : "text-red-400 text-sm mt-2"
    if (result.status === "success") {
      document.getElementById("addProjectForm").reset()
      setTimeout(() => renderProjectsTab(), 1000)
    }
  })
}
