const API_PROFILE = "../api/profile_api.php"

/* ============================
   🔹 GET ALL PROFILES
   ============================ */
export async function getProfiles() {
  try {
    const res = await fetch(API_PROFILE)
    const data = await res.json()
    // backend returns { status: ..., data: [...] }
    return data.data || []
  } catch (err) {
    console.error(" Error fetching profiles:", err)
    return []
  }
}

/* ============================
   🔹 GET SINGLE PROFILE
   ============================ */
export async function getProfile(id = 1) {
  try {
    console.log(" Fetching profile from:", `${API_PROFILE}?id=${id}`)
    const res = await fetch(`${API_PROFILE}?id=${id}`)
    const data = await res.json()
    // backend returns { status: ..., data: { ... } }
    console.log(" getProfile response:", data)
    return data.data || null
  } catch (err) {
    console.error(" Error fetching profile:", err)
    return null
  }
}

/* ============================
   🔹 ADD PROFILE
   ============================ */
export async function addProfile(profileData) {
  try {
    const res = await fetch(API_PROFILE, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(profileData),
    })
    return await res.json()
  } catch (err) {
    console.error(" Error adding profile:", err)
    return { status: "error", message: "Failed to add profile" }
  }
}

/* ============================
   🔹 UPDATE PROFILE
   ============================ */
export async function updateProfile(profileData) {
  try {
    const res = await fetch(`${API_PROFILE}?id=${profileData.id}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(profileData),
    })
    return await res.json()
  } catch (err) {
    console.error(" Error updating profile:", err)
    return { status: "error", message: "Failed to update profile" }
  }
}

/* ============================
   🔹 DELETE PROFILE
   ============================ */
export async function deleteProfile(id) {
  try {
    const res = await fetch(`${API_PROFILE}?id=${id}`, {
      method: "DELETE",
    })
    return await res.json()
  } catch (err) {
    console.error(" Error deleting profile:", err)
    return { status: "error", message: "Failed to delete profile" }
  }
}
