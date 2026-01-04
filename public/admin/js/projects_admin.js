import { getProjects, addProject, updateProject, deleteProject } from "../../js/api/projects.js";

const form = document.getElementById("projectForm");
const tableBody = document.querySelector("#projectsTable tbody");

document.addEventListener("DOMContentLoaded", async () => {
  await loadProjects();
});

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const id = document.getElementById("project_id").value;
  const projectData = {
    id,
    title: document.getElementById("title").value,
    description: document.getElementById("description").value,
    link: document.getElementById("link").value,
    tech_stack: document.getElementById("tech_stack").value,
    project_date: document.getElementById("project_date").value
  };

  const res = id ? await updateProject(projectData) : await addProject(projectData);
  alert(res.message);
  form.reset();
  await loadProjects();
});

async function loadProjects() {
  const projects = await getProjects();
  tableBody.innerHTML = "";

  projects.forEach(p => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${p.id}</td>
      <td>${p.title}</td>
      <td>${p.tech_stack}</td>
      <td>${p.project_date}</td>
      <td>
        <button onclick="editProject(${p.id}, '${p.title}', '${p.description}', '${p.link}', '${p.tech_stack}', '${p.project_date}')">Edit</button>
        <button onclick="removeProject(${p.id})">Delete</button>
      </td>
    `;
    tableBody.appendChild(row);
  });
}

window.editProject = (id, title, description, link, tech_stack, date) => {
  document.getElementById("project_id").value = id;
  document.getElementById("title").value = title;
  document.getElementById("description").value = description;
  document.getElementById("link").value = link;
  document.getElementById("tech_stack").value = tech_stack;
  document.getElementById("project_date").value = date;
};

window.removeProject = async (id) => {
  if (confirm("Delete this project?")) {
    const res = await deleteProject(id);
    alert(res.message);
    await loadProjects();
  }
};
