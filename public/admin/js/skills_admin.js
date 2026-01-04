import { getSkills, addSkill, updateSkill, deleteSkill } from "../../js/api/skills.js";

const form = document.getElementById("skillForm");
const tableBody = document.querySelector("#skillsTable tbody");

document.addEventListener("DOMContentLoaded", async () => {
  await loadSkills();
});

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const id = document.getElementById("skill_id").value;
  const skillData = {
    id,
    skill_name: document.getElementById("skill_name").value,
    proficiency_level: document.getElementById("proficiency_level").value,
    category: document.getElementById("category").value
  };

  const res = id ? await updateSkill(skillData) : await addSkill(skillData);
  alert(res.message);
  form.reset();
  await loadSkills();
});

async function loadSkills() {
  const skills = await getSkills();
  tableBody.innerHTML = "";

  skills.forEach(skill => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${skill.id}</td>
      <td>${skill.skill_name}</td>
      <td>${skill.proficiency_level}</td>
      <td>${skill.category}</td>
      <td>
        <button onclick="editSkill(${skill.id}, '${skill.skill_name}', '${skill.proficiency_level}', '${skill.category}')">Edit</button>
        <button onclick="removeSkill(${skill.id})">Delete</button>
      </td>
    `;
    tableBody.appendChild(row);
  });
}

// Make functions globally accessible
window.editSkill = (id, name, level, category) => {
  document.getElementById("skill_id").value = id;
  document.getElementById("skill_name").value = name;
  document.getElementById("proficiency_level").value = level;
  document.getElementById("category").value = category;
};

window.removeSkill = async (id) => {
  if (confirm("Delete this skill?")) {
    const res = await deleteSkill(id);
    alert(res.message);
    await loadSkills();
  }
};
