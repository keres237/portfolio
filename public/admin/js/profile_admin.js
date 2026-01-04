import { getProfile, updateProfile } from "../../js/api/profile.js";

document.addEventListener("DOMContentLoaded", async () => {
  const form = document.getElementById("profileForm");
  const msgBox = document.getElementById("msgBox");
  const resetBtn = document.getElementById("btnReset");

  // 1️⃣ Load current profile data
  const profile = await getProfile(1);
  if (profile) fillForm(profile);

  // 2️⃣ Handle form submission (update)
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const updatedData = {
      id: 1, // assuming single profile
      full_name: form.full_name.value,
      title: form.title.value,
      email: form.email.value,
      phone: form.phone.value,
      bio: form.bio.value,
      profile_image: form.profile_image.value
    };

    const res = await updateProfile(updatedData);
    msgBox.textContent = res.message || "Profile updated successfully!";
    msgBox.style.color = res.status === "success" ? "green" : "red";
  });

  // 3️⃣ Reset form
  resetBtn.addEventListener("click", () => fillForm(profile));

  function fillForm(p) {
    form.full_name.value = p.full_name || "";
    form.title.value = p.title || "";
    form.email.value = p.email || "";
    form.phone.value = p.phone || "";
    form.bio.value = p.bio || "";
    form.profile_image.value = p.profile_image || "";
  }
});
