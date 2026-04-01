document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('studentTableBody');
    const statsList = document.getElementById('statsList');
    const deptFilter = document.getElementById('deptFilter');
    const sortBy = document.getElementById('sortBy');
    const totalCount = document.getElementById('totalCount');

    const fetchStudents = async () => {
        const filter = deptFilter.value;
        const sort = sortBy.value;
        
        try {
            const response = await fetch(`api.php?action=get_students&filter=${filter}&sort=${sort}`);
            const students = await response.json();
            
            tableBody.innerHTML = '';
            students.forEach(student => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${student.name}</td>
                    <td>${student.email}</td>
                    <td>${student.dob}</td>
                    <td><span class="badge">${student.department}</span></td>
                    <td>${student.phone}</td>
                `;
                tableBody.appendChild(row);
            });
            totalCount.textContent = `Total Students: ${students.length}`;
        } catch (error) {
            console.error('Error:', error);
        }
    };

    const fetchStats = async () => {
        try {
            const response = await fetch('api.php?action=get_stats');
            const stats = await response.json();
            
            statsList.innerHTML = '';
            stats.forEach(stat => {
                const item = document.createElement('div');
                item.className = 'stat-item';
                item.innerHTML = `
                    <div class="dept">${stat.department}</div>
                    <div class="val">${stat.count}</div>
                `;
                statsList.appendChild(item);
            });
        } catch (error) {
            console.error('Error stats:', error);
        }
    };

    deptFilter.addEventListener('change', fetchStudents);
    sortBy.addEventListener('change', fetchStudents);

    // Initial load
    fetchStudents();
    fetchStats();
});
