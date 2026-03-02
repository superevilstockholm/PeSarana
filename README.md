# **PeSarana**  

**PeSarana** adalah sistem informasi berbasis web yang dirancang untuk mengelola proses pelaporan dan penanganan sarana serta prasarana sekolah secara terstruktur dan terdokumentasi. Sistem ini memungkinkan siswa menyampaikan laporan kerusakan atau kebutuhan fasilitas, serta memungkinkan pihak administrasi melakukan verifikasi, tindak lanjut, dan pemantauan progres penyelesaian secara sistematis.  

**PeSarana** dikembangkan menggunakan framework **Laravel 12** dan database **PostgreSQL**.  

### Tujuan Sistem:  

1. Menyediakan kanal resmi pengaduan sarana dan prasarana sekolah  
2. Mencatat dan menyimpan histori laporan secara terstruktur  
3. Mempermudah pemantauan progres penanganan laporan  
4. Meningkatkan transparansi proses penyelesaian  
5. Mengurangi komunikasi informal yang tidak terdokumentasi  

### Sistem Pengguna  

1. *Student* (Siswa)  

    - Melihat daftar aspirasi yang telah dibuat
    - Membuat laporan (aspirasi) baru
    - Melihat status perkembangan laporan
    - Melihat feedback atau tanggapan dari admin

2. Admin  

    - Memverifikasi dan memvalidasi laporan yang masuk
    - Mengubah status laporan sesuai progres penanganan
    - Memberikan feedback atau tanggapan terhadap laporan
    - Mengelola data master, meliputi:  

        - Data *Classroom* (Kelas)
        - Data *Student* (Siswa)
        - Data *Category* (Kategori)
        - Data *User* (Pengguna)

## 1. Database  

![ERD PeSarana - dbdiagram.io](repo_assets/ERD_PeSarana.svg)  

<h4 align="center">Gambar 1.1 ERD - PeSarana</h4>  

---

### Table Users  

- id (primary key, auto increment)  
- name (varchar(255), not null)  
- email (varchar(255), not null, unique)  
- password (varchar(255), not null)  
- role (varchar(255), not null, default(student))  <!-- admin dan student -->
- profile_picture_path (varchar(255), null)  
- created_at (timestamp, null)  
- updated_at (timestamp, null)  

### Table Classrooms  

- id (primary key, auto increment)  
- name (varchar(255), not null, unique)  
- created_at (timestamp, null)  
- updated_at (timestamp, null)  

### Table Students  

- id (primary key, auto increment)  
- nisn (varchar(10), not null, unique)  
- name (varchar(255), not null)  
- dob (date, not null)  
- classroom_id (foreignId(classrooms.id), not null, ondelete(cascade))  
- user_id (foreignId(users.id), null, ondelete(set null))  
- created_at (timestamp, null)  
- updated_at (timestamp, null)  

### Table Categories  

- id (primary key, auto increment)  
- name (varchar(255), not null, unique)  
- created_at (timestamp, null)  
- updated_at (timestamp, null)  

### Table  Aspirations  

- id (primary key, auto increment)  
- title (varchar(255), not null)  
- content (text, null)  
- location (varchar(255), not null)  
- status (varchar(255), not null, default(pending))  <!-- pending, on_going, dan completed, rejected -->
- student_id (foreignId(students.id), not null, ondelete(cascade))  
- category_id (foreignId(categories.id), not null, ondelete(cascade))  
- created_at (timestamp, null)  
- updated_at (timestamp, null)  

### Table Aspiration Images  

- id (primary key, auto increment)  
- image_path (varchar(255), not null)  
- aspiration_id (foreignId(aspirations.id), nota null, ondelete(cascade))  
- created_at (timestamp, null)  
- updated_at (timestamp, null)  

### Table Aspiration Feedbacks  

- id (primary key, auto increment)  
- content (text, null)  
- status (varchar(255), not null)  <!-- pending, on_going, completed, dan rejected -->
- user_id (foreignId(users.id), null, ondelete(set null))  
- aspiration_id (foreignId(aspirations.id), not null, ondelete(cascade))  
- created_at (timestamp, null)  
- updated_at (timestamp, null)  

### dbdiagram.io script  

```dbml
Table users {
    id BIGINT [pk, increment]
    name VARCHAR(255) [not null]
    email VARCHAR(255) [unique, not null]
    password VARCHAR(255) [not null]
    // role ENUM('admin', 'student') [default: 'student']
    role VARCHAR(255) [not null, default: 'student']
    profile_picture_path VARCHAR(255) [null]
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Table classrooms {
    id BIGINT [pk, increment]
    name VARCHAR(255) [unique, not null]
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Table students {
    id BIGINT [pk, increment]
    nisn VARCHAR(10) [unique, not null]
    name VARCHAR(255) [not null]
    dob DATE [not null]
    classroom_id BIGINT [not null]
    user_id BIGINT [null, unique]
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Ref: students.classroom_id > classrooms.id [delete: cascade]
Ref: students.user_id - users.id [delete: set null]

Table categories {
    id BIGINT [pk, increment]
    name VARCHAR(255) [unique, not null]
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Table aspirations {
    id BIGINT [pk, increment]
    title VARCHAR(255) [not null]
    content TEXT [null]
    location VARCHAR(255) [not null]
    // status ENUM('pending', 'on_progress', 'completed', 'rejected') [default: 'pending']
    status VARCHAR(255) [not null, default: 'pending']
    student_id BIGINT [not null]
    category_id BIGINT [not null]
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Ref: aspirations.student_id > students.id [delete: cascade]
Ref: aspirations.category_id > categories.id [delete: cascade]

Table aspiration_images {
    id BIGINT [pk, increment]
    image_path VARCHAR(255) [not null]
    aspiration_id BIGINT [not null]
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Ref: aspiration_images.aspiration_id > aspirations.id [delete: cascade]

Table aspiration_feedbacks {
    id BIGINT [pk, increment]
    content TEXT [null]
    // status ENUM('pending', 'on_progress', 'completed', 'rejected')
    status VARCHAR(255) [not null]
    user_id BIGINT [null]
    aspiration_id BIGINT [not null]
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Ref: aspiration_feedbacks.aspiration_id > aspirations.id [delete: cascade]
Ref: aspiration_feedbacks.user_id - users.id [delete: set null]
```  

## 2. Flowchart  

![Flowchart PeSarana - app.diagram.com](repo_assets/Flowchart_PeSarana.svg)  

<h4 align="center">Gambar 2.1 Flowchart - PeSarana</h4>  

---


