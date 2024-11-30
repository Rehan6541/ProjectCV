document.addEventListener("DOMContentLoaded", function() {
    let projectCount = 1;

    // Function to add a new project input group
    function addProjectFields() {
        const projectDiv = document.createElement('div');
        projectDiv.classList.add('project');
        projectDiv.innerHTML = `
            <label for="project-name-${projectCount}">Project Name:</label>
            <input type="text" class="project-name" id="project-name-${projectCount}" required>
            <label for="project-description-${projectCount}">Project Description:</label>
            <textarea class="project-description" id="project-description-${projectCount}" required></textarea>
            <button type="button" class="remove-project">Remove Project</button>
            <hr>
        `;

        document.getElementById('projects').appendChild(projectDiv);

        // Event listener to remove project fields
        projectDiv.querySelector('.remove-project').addEventListener('click', () => {
            projectDiv.remove();
        });

        projectCount++;
    }

    // Event listener to add more projects dynamically
    document.getElementById('add-project').addEventListener('click', addProjectFields);

    // Event listener for form submission
    document.getElementById('portfolio-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('number', document.getElementById('number').value);
        formData.append('address', document.getElementById('address').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('linkedin', document.getElementById('linkedin').value);
        formData.append('github', document.getElementById('github').value);
        formData.append('education', document.getElementById('education').value);
        formData.append('skills', document.getElementById('skills').value);
        formData.append('hobbies', document.getElementById('hobbies').value);
        formData.append('certificates', document.getElementById('certificates').value);
        formData.append('internships', document.getElementById('internships').value);

        // Gather project data
        const projects = [];
        document.querySelectorAll('.project').forEach((projectDiv) => {
            const projectName = projectDiv.querySelector('.project-name').value;
            const projectDescription = projectDiv.querySelector('.project-description').value;
            projects.push({ name: projectName, description: projectDescription });
        });
        formData.append('projects', JSON.stringify(projects));

        // Send data to save_profile.php
        fetch('save_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert('Profile saved successfully!');
            console.log(data); // for debugging
        })
        .catch(error => console.error('Error:', error));
    });
});
