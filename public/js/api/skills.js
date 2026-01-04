const API_SKILLS = "../api/skills_api.php"

export async function getSkills() {
  try {
    console.log(" Fetching skills from:", API_SKILLS)
    const res = await fetch(API_SKILLS)
    const data = await res.json()
    console.log(" Skills response:", data)
    return data.skills || []
  } catch (err) {
    console.error("Error fetching skills:", err)
    return []
  }
}

export async function addSkill(skillData) {
  try {
    const res = await fetch(API_SKILLS, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(skillData),
    })
    return res.json()
  } catch (err) {
    console.error("Error adding skill:", err)
    return { status: "error", message: "Failed to add skill" }
  }
}

export async function updateSkill(skillData) {
  try {
    const res = await fetch(API_SKILLS, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(skillData),
    })
    return res.json()
  } catch (err) {
    console.error(" Error updating skill:", err)
    return { status: "error", message: "Failed to update skill" }
  }
}

export async function deleteSkill(id) {
  try {
    const res = await fetch(`${API_SKILLS}?id=${id}`, { method: "DELETE" })
    return res.json()
  } catch (err) {
    console.error("Error deleting skill:", err)
    return { status: "error", message: "Failed to delete skill" }
  }
}
