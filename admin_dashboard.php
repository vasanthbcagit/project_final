<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - Scholarship Portal</title>
<style>
  body { margin:0; font-family:"Segoe UI",Arial,sans-serif; height:100vh; display:flex; justify-content:center; align-items:flex-start; background:linear-gradient(135deg,#e6e6e6,#c9c9c9); overflow:hidden; }
  .bg-squares div { position:absolute; background:#14283a; width:140px; height:140px; transform:rotate(45deg); opacity:0.8; animation:floatSquare 6s infinite ease-in-out alternate; border-radius:8px; }
  .bg-squares .light { background:#ebebeb; animation:blink 3s infinite ease-in-out alternate; }
  @keyframes floatSquare {0%{transform:translateY(0) rotate(45deg);}100%{transform:translateY(-25px) rotate(45deg);}}
  @keyframes blink{0%{opacity:0.6;}100%{opacity:1;}}
  .s1{top:5%;right:12%;animation-delay:0s;}
  .s2{top:30%;right:-4%;width:110px;height:110px;animation-delay:1s;}
  .s3{top:60%;right:10%;width:90px;height:90px;animation-delay:2s;}
  .s4{top:20%;right:30%;width:100px;height:100px;animation-delay:1.5s;}
  .s5{top:70%;right:28%;width:70px;height:70px;animation-delay:0.5s;}
  .container{width:90%;max-width:1200px;margin:30px auto;background:#ffffffd9;padding:25px;border-radius:18px;backdrop-filter:blur(6px);box-shadow:0 15px 35px rgba(0,0,0,0.25);position:relative; z-index:5; display:flex; flex-direction:column; animation:fadeIn 1.2s ease-in-out;}
  @keyframes fadeIn{from{opacity:0; transform:translateY(40px);}to{opacity:1; transform:translateY(0);}}
  h2{text-align:center;color:#14283a;margin-bottom:10px;font-weight:bold;}
  .top-right{display:flex;gap:20px;align-items:center;margin-left:auto;margin-bottom:15px;}
  .dashboard{display:flex;gap:15px;}
  .sidebar{flex:0 0 220px;background:#14283a;color:white;padding:20px;border-radius:12px;display:flex;flex-direction:column;}
  .sidebar a{display:block;padding:12px 18px;margin:5px 0;border-radius:8px;color:white;text-decoration:none;cursor:pointer;transition:0.3s;}
  .sidebar a:hover,.sidebar a.active{background:#1e3b5a;}
  .main{flex:1;padding:20px;background:#f9f9f9d9;border-radius:12px;overflow-y:auto;max-height:80vh;}
  .section{display:none;}
  .section.active{display:block; animation:fadeIn 0.5s ease-in-out;}
  input,select,button{width:100%;padding:10px;margin:5px 0 15px 0;border-radius:8px;border:1px solid #ccc;}
  button{background:#14283a;color:white;border:none;cursor:pointer;transition:0.3s;}
  button:hover{background:#0d1b28;transform:scale(1.03);}
  table{width:100%;border-collapse:collapse;margin-top:10px;}
  th,td{padding:8px;text-align:center;border:1px solid #ccc;vertical-align:middle;}
  th{background:#14283a;color:white;}
  .status-inprocess{background:#f39c12;color:white;padding:4px 10px;border-radius:5px;}
  .status-approved{background:#1abc9c;color:white;padding:4px 10px;border-radius:5px;}
  .status-cancelled{background:#e74c3c;color:white;padding:4px 10px;border-radius:5px;}
  .file-box{display:inline-block;background:#14283a;color:white;padding:5px 10px;margin:3px 3px;border-radius:6px;cursor:pointer;font-size:13px;transition:0.2s;}
  .file-box:hover{background:#0d1b28; transform:scale(1.05);}
</style>
</head>
<body>

<div class="bg-squares">
  <div class="s1"></div>
  <div class="s2"></div>
  <div class="s3"></div>
  <div class="s4 light"></div>
  <div class="s5 light"></div>
</div>

<div class="container">
  <h2>Admin Dashboard</h2>
  <div class="top-right">
      <div style="text-align:right">
        <div style="font-size:12px;color:#3f5b6b">Logged in as</div>
        <div style="font-weight:800;color:#0f2940">Admin User</div>
      </div>
      <button onclick="logout()" style="padding:8px 14px;background:#e74c3c;color:white;border:none;font-weight:700;border-radius:8px;cursor:pointer;box-shadow:0 6px 14px rgba(231,76,60,0.3);">Logout</button>
  </div>

  <div class="dashboard">
    <div class="sidebar">
      <a onclick="showSection('upload')" class="active">Upload Scholarship</a>
      <a onclick="showSection('students')">Student Applied Details</a>
      <a onclick="showSection('status')">Scholarship Status</a>
    </div>

    <div class="main">
      <!-- Upload -->
      <div id="upload" class="section active">
        <h3>Upload New Scholarship</h3>
        <label>Scholarship Name</label>
        <input type="text" id="schName" placeholder="Enter Scholarship Name">
        <label>Department</label>
        <select id="schDept">
          <option value="">Select Department</option>
          <option>Computer Science</option>
          <option>Mechanical</option>
          <option>Electrical</option>
          <option>Civil</option>
          <option>EEE</option>
          <option>ECE</option>
          <option>IT</option>
          <option>Other</option>
          <option>All Department</option>
        </select>
        <button onclick="uploadScholarship()">Upload</button>

        <h4>Available Scholarships:</h4>
        <table id="schList">
          <thead>
            <tr><th>Name</th><th>Department</th><th>Action</th></tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <!-- Students -->
      <div id="students" class="section">
        <h3>Student Applied Details</h3>
        <table id="studentTable">
          <thead>
            <tr><th>Name</th><th>Scholarship</th><th>Department</th><th>Files</th><th>Status</th><th>Action</th></tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <!-- Status -->
      <div id="status" class="section">
        <h3>Scholarship Status</h3>
        <h4>In Process</h4><ul id="statusInProcess"></ul>
        <h4>Approved</h4><ul id="statusApproved"></ul>
        <h4>Cancelled</h4><ul id="statusCancelled"></ul>
      </div>
    </div>
  </div>
</div>
<script>
let scholarships = [];
let students = [];

async function fetchScholarships(){
    try{
        const res = await fetch("fetch_scholarships.php",{method:"POST"});
        scholarships = await res.json();
        renderScholarships();
    }catch(err){ console.error(err); }
}

async function fetchStudents(){
    try{
        const res = await fetch("fetch_students.php",{method:"POST"});
        students = await res.json();
        renderStudents();
        renderStatusLists();
    }catch(err){ console.error(err); }
}

function renderScholarships(){
    const tbody = document.querySelector("#schList tbody");
    tbody.innerHTML="";
    scholarships.forEach(s=>{
        tbody.innerHTML += `
        <tr>
            <td>${s.name}</td>
            <td>${s.department}</td>
            <td>
                <a href="delete_scholarship.php?id=${s.id}" 
                   onclick="return confirm('Delete this scholarship?')">Delete</a>
            </td>
        </tr>`;
    });
}

function renderStudents(){
    const tbody = document.querySelector("#studentTable tbody");
    tbody.innerHTML="";

    students.forEach(s=>{
        let filesHTML = (s.files||[])
            .map(f=>`<span class="file-box" onclick="viewFile('${f.path}')">📄 ${f.name}</span>`)
            .join(" ");

        let status = s.status ?? "pending";

        let statusText =
            status === "approved" ? "Approved" :
            status === "cancelled" ? "Cancelled" :
            "In Process";

        let statusClass =
            status === "approved" ? "status-approved" :
            status === "cancelled" ? "status-cancelled" :
            "status-inprocess";

        tbody.innerHTML += `
        <tr>
            <td>${s.name || "N/A"}</td>
            <td>${s.scholarship_name || "N/A"}</td>
            <td>${s.department || "N/A"}</td>
            <td>${filesHTML}</td>
            <td><span class="${statusClass}">${statusText}</span></td>
            <td>
                <button onclick="changeStatus(${s.id},'approved')">Approve</button>
                <button onclick="changeStatus(${s.id},'cancelled')">Cancel</button>
            </td>
        </tr>`;
    });
}

function renderStatusLists(){
    const map = {
        pending: "statusInProcess",
        approved: "statusApproved",
        cancelled: "statusCancelled"
    };

    Object.values(map).forEach(id=>{
        document.getElementById(id).innerHTML="";
    });

    students.forEach(s=>{
        let status = s.status ?? "pending";
        let ul = document.getElementById(map[status]);
        if(ul){
            let li = document.createElement("li");
            li.textContent = `${s.name} - ${s.scholarship_name}`;
            ul.appendChild(li);
        }
    });
}

function uploadScholarship(){
    const name=document.getElementById("schName").value.trim();
    const dept=document.getElementById("schDept").value;

    if(!name || !dept){
        alert("Enter Scholarship Name and Department");
        return;
    }

    fetch("upload_scholarship.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:`name=${encodeURIComponent(name)}&department=${encodeURIComponent(dept)}`
    })
    .then(res=>res.text())
    .then(data=>{
        if(data.trim()==="success"){
            alert("Scholarship uploaded!");
            fetchScholarships();
            document.getElementById("schName").value="";
            document.getElementById("schDept").value="";
        }else{
            alert("Error uploading scholarship");
            console.log(data);
        }
    });
}

async function changeStatus(id,status){
    const formData=new FormData();
    formData.append("id",id);
    formData.append("status",status);

    try{
        const res=await fetch("change_status.php",{method:"POST",body:formData});
        const text=await res.text();
        if(text.trim()==="success") fetchStudents();
        else alert("Failed to update status");
    }catch(e){
        console.error(e);
        alert("Error updating status");
    }
}

function viewFile(filename){
    window.open(filename,"_blank");
}

function showSection(sectionId, el){
    document.querySelectorAll(".section").forEach(s=>s.classList.remove("active"));
    document.getElementById(sectionId).classList.add("active");

    document.querySelectorAll(".sidebar a").forEach(a=>a.classList.remove("active"));
    el.classList.add("active");
}

function logout(){
    window.location.href="login.html";
}

// Initial load
fetchScholarships();
fetchStudents();
</script>


</body>
</html>
