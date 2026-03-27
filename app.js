// Sample Data
const directoryData = [
    { id: 1, name: "Alice Johnson", department: "Engineering", role: "Software Engineer", dateJoined: "2023-01-15", type: "Employee", avatarColor: "#6366f1" },
    { id: 2, name: "Bob Smith", department: "Marketing", role: "Content Strategist", dateJoined: "2022-11-20", type: "Employee", avatarColor: "#ec4899" },
    { id: 3, name: "Charlie Davis", department: "Computer Science", role: "Undergraduate", dateJoined: "2024-09-01", type: "Student", avatarColor: "#10b981" },
    { id: 4, name: "Diana Prince", department: "Design", role: "UI/UX Designer", dateJoined: "2023-05-10", type: "Employee", avatarColor: "#f59e0b" },
    { id: 5, name: "Evan Wright", department: "Engineering", role: "DevOps Engineer", dateJoined: "2021-08-25", type: "Employee", avatarColor: "#6366f1" },
    { id: 6, name: "Fiona Gallagher", department: "Business", role: "MBA Candidate", dateJoined: "2023-09-05", type: "Student", avatarColor: "#8b5cf6" },
    { id: 7, name: "George Miller", department: "Computer Science", role: "Graduate Student", dateJoined: "2022-09-01", type: "Student", avatarColor: "#10b981" },
    { id: 8, name: "Hannah Abbott", department: "Marketing", role: "SEO Specialist", dateJoined: "2024-01-12", type: "Employee", avatarColor: "#ec4899" },
    { id: 9, name: "Ian Malcolm", department: "Design", role: "Graphic Design Student", dateJoined: "2023-09-15", type: "Student", avatarColor: "#f59e0b" },
    { id: 10, name: "Julia Roberts", department: "Engineering", role: "Frontend Developer", dateJoined: "2024-02-28", type: "Employee", avatarColor: "#6366f1" }
];

// DOM Elements
const recordsGrid = document.getElementById('recordsGrid');
const statsGrid = document.getElementById('statsGrid');
const searchInput = document.getElementById('searchInput');
const departmentFilter = document.getElementById('departmentFilter');
const sortControl = document.getElementById('sortControl');
const noResults = document.getElementById('noResults');

// Initialize Dashboard
function init() {
    populateDepartmentFilter();
    renderStats();
    renderRecords(directoryData);

    // Event Listeners
    searchInput.addEventListener('input', handleFilterAndSort);
    departmentFilter.addEventListener('change', handleFilterAndSort);
    sortControl.addEventListener('change', handleFilterAndSort);
}

// Populate Department Filter Dropdown
function populateDepartmentFilter() {
    const departments = [...new Set(directoryData.map(item => item.department))].sort();
    departments.forEach(dept => {
        const option = document.createElement('option');
        option.value = dept;
        option.textContent = dept;
        departmentFilter.appendChild(option);
    });
}

// Render Department Counts
function renderStats() {
    // Count per department
    const deptCounts = directoryData.reduce((acc, curr) => {
        acc[curr.department] = (acc[curr.department] || 0) + 1;
        return acc;
    }, {});

    statsGrid.innerHTML = '';
    
    // Icons map for aesthetics
    const iconMap = {
        "Engineering": "fa-code",
        "Marketing": "fa-bullhorn",
        "Computer Science": "fa-laptop-code",
        "Design": "fa-pen-nib",
        "Business": "fa-chart-line"
    };

    Object.entries(deptCounts).forEach(([dept, count], index) => {
        const iconClass = iconMap[dept] || "fa-users";
        const delay = index * 0.1;
        
        const statCard = document.createElement('div');
        statCard.className = 'stat-card animate-in';
        statCard.style.animationDelay = `${delay}s`;
        
        statCard.innerHTML = `
            <i class="fa-solid ${iconClass} dept-icon"></i>
            <div class="stat-value">${count}</div>
            <div class="stat-label">${dept}</div>
        `;
        statsGrid.appendChild(statCard);
    });
}

// Main logic for handling search, filter and sort
function handleFilterAndSort() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedDept = departmentFilter.value;
    const sortValue = sortControl.value;

    let filteredData = directoryData.filter(item => {
        const matchesSearch = item.name.toLowerCase().includes(searchTerm) || item.role.toLowerCase().includes(searchTerm);
        const matchesDept = selectedDept === 'All' || item.department === selectedDept;
        return matchesSearch && matchesDept;
    });

    // Handle Sorting
    filteredData.sort((a, b) => {
        if (sortValue === 'name-asc') {
            return a.name.localeCompare(b.name);
        } else if (sortValue === 'name-desc') {
            return b.name.localeCompare(a.name);
        } else if (sortValue === 'date-desc') {
            return new Date(b.dateJoined) - new Date(a.dateJoined);
        } else if (sortValue === 'date-asc') {
            return new Date(a.dateJoined) - new Date(b.dateJoined);
        }
    });

    renderRecords(filteredData);
}

// Render Records to Grid
function renderRecords(data) {
    recordsGrid.innerHTML = '';
    
    if (data.length === 0) {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList.add('hidden');
        data.forEach((item, index) => {
            const delay = index * 0.05; // Staggered animation
            
            // Format date carefully
            const dateObj = new Date(item.dateJoined);
            const formattedDate = dateObj.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            // Get initials
            const initials = item.name.split(' ').map(n => n[0]).join('').substring(0, 2);

            const card = document.createElement('div');
            card.className = 'record-card animate-in';
            card.style.animationDelay = `${delay}s`;

            card.innerHTML = `
                <div class="record-header">
                    <div class="record-avatar" style="background-color: ${item.avatarColor}">
                        ${initials}
                    </div>
                    <div class="record-details">
                        <h3>${item.name}</h3>
                        <p>${item.role}</p>
                    </div>
                </div>
                <div>
                    <span class="badge badge-dept">
                        <i class="fa-solid fa-building fa-fw" style="margin-right: 4px;"></i> ${item.department}
                    </span>
                    <span class="badge" style="margin-left: 0.5rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                        ${item.type === 'Student' ? '<i class="fa-solid fa-graduation-cap"></i> Student' : '<i class="fa-solid fa-briefcase"></i> Employee'}
                    </span>
                </div>
                <div class="record-meta">
                    <span><i class="fa-regular fa-calendar-plus" style="margin-right: 4px;"></i> Joined</span>
                    <span>${formattedDate}</span>
                </div>
            `;
            recordsGrid.appendChild(card);
        });
    }
}

// Boot application
init();
