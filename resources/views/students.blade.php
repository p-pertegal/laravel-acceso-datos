<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .student {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .student h3 {
            margin: 0;
        }

        .student p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
<h1>Student Management</h1>
<div id="students">
    <!-- Students will be loaded here -->
</div>

<h2>Add New Student</h2>
<form id="studentForm">
    <input type="text" id="nia" placeholder="NIA" required>
    <input type="text" id="dni" placeholder="DNI" required>
    <input type="text" id="name" placeholder="Name" required>
    <input type="text" id="phone" placeholder="Phone" required>
    <input type="text" id="location" placeholder="Location" required>
    <input type="email" id="email" placeholder="Email" required>
    <button type="submit">Add Student</button>
</form>

<script>
    // Load students on page load
    fetch('/api/students')
        .then(response => response.json())
        .then(data => {
            const studentsContainer =
document.getElementById('students');
            data.forEach(student => {
                studentsContainer.innerHTML += `
                    <div class="student" data-id="${student.id}">
                        <h3>${student.name} (NIA: ${student.nia})</h3>
                        <p>DNI: ${student.dni}</p>
                        <p>Phone: ${student.phone}</p>
                        <p>Location: ${student.location}</p>
                        <p>Email: ${student.email}</p>
                        <button
onclick="editStudent(${student.id})">Edit</button>
                        <button
onclick="deleteStudent(${student.id})">Delete</button>
                    </div>
                `;
            });
        });

    // Add new student
    document.getElementById('studentForm').addEventListener('submit',
function (e) {
        e.preventDefault();
        const nia = document.getElementById('nia').value;
        const dni = document.getElementById('dni').value;
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
    const location = document.getElementById('location').value; 
const email = document.getElementById('email').value; 
fetch('/api/students', { 
method: 'POST', 
headers: { 'Content-Type': 'application/json' }, 
body: JSON.stringify({ nia, dni, name, phone, location, email 
}) 
}) 
.then(response => response.json()) 
.then(student => { 
const studentsContainer = 
document.getElementById('students'); 
studentsContainer.innerHTML += ` 
<div class="student" data-id="${student.id}"> 
<h3>${student.name} (NIA: ${student.nia})</h3> 
<p>DNI: ${student.dni}</p> 
<p>Phone: ${student.phone}</p> 
<p>Location: ${student.location}</p> 
<p>Email: ${student.email}</p> 
<button 
onclick="editStudent(${student.id})">Edit</button> 
<button 
onclick="deleteStudent(${student.id})">Delete</button> 
</div> 
`; 
document.getElementById('studentForm').reset(); 
}); 
}); 
// Delete student 
function deleteStudent(id) { 
fetch(`/api/students/${id}`, { method: 'DELETE' }) 
.then(() => { 
document.querySelector(`.student[data
id="${id}"]`).remove(); 
}); 
}
</script>
</body>
</html> 
