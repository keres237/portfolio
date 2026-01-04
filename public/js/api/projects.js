const API_PROJECTS = "../api/projects_api.php"

export async function getProjects() {
  try {
    console.log("Fetching projects from:", API_PROJECTS)
    const res = await fetch(API_PROJECTS)
    const data = await res.json()
    console.log(" Projects response:", data)
    return data.projects || []
  } catch (err) {
    console.error(" Error fetching projects:", err)
    return []
  }
}

export async function addProject(projectData) {
  try {
    const res = await fetch(API_PROJECTS, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(projectData),
    })
    return res.json()
  } catch (err) {
    console.error("Error adding project:", err)
    return { status: "error", message: "Failed to add project" }
  }
}

export async function updateProject(projectData) {
  try {
    const res = await fetch(API_PROJECTS, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(projectData),
    })
    return res.json()
  } catch (err) {
    console.error(" Error updating project:", err)
    return { status: "error", message: "Failed to update project" }
  }
}

export async function deleteProject(id) {
  try {
    const res = await fetch(`${API_PROJECTS}?id=${id}`, { method: "DELETE" })
    return res.json()
  } catch (err) {
    console.error(" Error deleting project:", err)
    return { status: "error", message: "Failed to delete project" }
  }
}
