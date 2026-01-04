const API_AUTH = "../api/auth_api.php"

export async function login(username, password) {
  try {
    console.log(" Attempting login to:", API_AUTH)
    const res = await fetch(API_AUTH, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      credentials: "include",
      body: JSON.stringify({ action: "login", username, password }),
    })

    console.log("Login response status:", res.status)
    const data = await res.json()
    console.log(" Login response data:", data)

    if (!res.ok) {
      return { status: "error", logged_in: false, message: data.message || "Login failed" }
    }

    return data
  } catch (err) {
    console.error(" Login error:", err)
    return { status: "error", logged_in: false, message: "Network error: " + err.message }
  }
}

export async function logout() {
  try {
    const res = await fetch(API_AUTH, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      credentials: "include",
      body: JSON.stringify({ action: "logout" }),
    })
    return await res.json()
  } catch (err) {
    console.error(" Logout error:", err)
    return { status: "error", message: "Logout failed" }
  }
}

export async function checkAuth() {
  try {
    const res = await fetch(API_AUTH, {
      credentials: "include",
    })
    const data = await res.json()
    return data.logged_in || false
  } catch (err) {
    console.error("Auth check error:", err)
    return false
  }
}
