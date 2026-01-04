import { getProfile } from "./api/profile.js"
import { getSkills } from "./api/skills.js"
import { getProjects } from "./api/projects.js"

document.addEventListener("DOMContentLoaded", async () => {
  // --- PROFILE ---
  try {
    console.log(" Loading profile data...")
    const profile = await getProfile(1)
    console.log("Profile loaded:", profile)
    if (profile) {
      const imgEl = document.getElementById("profile-image")
      const nameEl = document.getElementById("profile-name")
      const titleEl = document.getElementById("profile-title")
      const bioEl = document.getElementById("profile-bio")
      const emailEl = document.getElementById("profile-email")
      const phoneEl = document.getElementById("profile-phone")

      if (imgEl && profile.profile_image) imgEl.src = profile.profile_image
      if (nameEl && profile.full_name) nameEl.textContent = profile.full_name
      if (titleEl && profile.title) titleEl.textContent = profile.title
      if (bioEl && profile.bio) bioEl.textContent = profile.bio
      if (emailEl && profile.email) emailEl.textContent = profile.email
      if (phoneEl && profile.phone) phoneEl.textContent = profile.phone
    }
  } catch (err) {
    console.error("Error populating profile UI:", err)
  }

  // --- SKILLS ---
  console.log(" Loading skills data...")
  const skills = await getSkills()
  const skillsList = document.getElementById("skills-list")
  if (skillsList && skills.length > 0) {
    skillsList.innerHTML = skills
      .map(
        (s) =>
          `<li class="px-4 py-3 bg-slate-800 rounded border border-slate-700"><span class="font-medium">${s.skill_name}</span><br/><span class="text-xs text-slate-400">${s.proficiency_level}</span></li>`,
      )
      .join("")
  }

  // --- PROJECTS ---
  console.log(" Loading projects data...")
  const projects = await getProjects()
  const container = document.getElementById("projects-container")
  if (container && projects.length > 0) {
    container.innerHTML = projects
      .map(
        (p) => `
      <div class="project-card p-6 bg-slate-900 border border-slate-800 rounded-lg hover:border-cyan-400 transition">
        <h3 class="text-xl font-bold text-white mb-2">${p.title}</h3>
        <p class="text-slate-400 mb-4">${p.description || "No description"}</p>
        <div class="flex flex-wrap gap-2 mb-4">
          ${
            p.tech_stack
              ? p.tech_stack
                  .split(",")
                  .map(
                    (tech) =>
                      `<span class="px-2 py-1 text-xs bg-cyan-500/20 text-cyan-300 rounded">${tech.trim()}</span>`,
                  )
                  .join("")
              : ""
          }
        </div>
        ${p.link ? `<a href="${p.link}" target="_blank" class="inline-block text-cyan-400 hover:text-cyan-300 font-medium">View Project →</a>` : ""}
      </div>
    `,
      )
      .join("")
  }
})
