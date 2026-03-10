# System Diagrams - Raaster Shuttle
## 1. Context Diagram (DFD Level 0)

```mermaid
flowchart TD
    %% External Entities
    E1[Penumpang]
    E2[Admin]
    E3[Driver]

    %% Main System Process
    S((Sistem Informasi<br>Raaster Shuttle))

    %% Flows E1 <-> System
    E1 -->|Data Registrasi| S
    E1 -->|Data Pemesanan| S
    E1 -->|Bukti Pembayaran| S
    S -->|Tiket / Kode Booking| E1
    S -->|Info Jadwal & Rute| E1
    S -->|Status Pembayaran| E1

    %% Flows E2 <-> System
    E2 -->|Data Rute, Jadwal, Armada| S
    E2 -->|Validasi Pembayaran| S
    S -->|Laporan Transaksi| E2
    S -->|Laporan Okupansi| E2

    %% Flows E3 <-> System
    E3 -->|Update Lokasi| S
    S -->|Jadwal Penugasan| E3
    S -->|Manifes Penumpang| E3
```

---

## 2. Data Flow Diagram (DFD Level 1)

```mermaid
flowchart LR
    %% Entities
    E_P[Penumpang]
    E_A[Admin]

    %% Processes
    P1((1.0<br>Autentikasi))
    P2((2.0<br>Kelola Data Master))
    P3((3.0<br>Transaksi Pemesanan))
    P4((4.0<br>Laporan))

    %% Data Stores
    DS1[(D1 Data User)]
    DS2[(D2 Data Jadwal/Rute)]
    DS3[(D3 Data Pemesanan)]

    %% Connections - Process 1.0
    E_P -->|Login/Register| P1
    E_A -->|Login| P1
    P1 -->|Simpan/Baca| DS1

    %% Connections - Process 2.0
    E_A -->|Input Rute/Jadwal| P2
    P2 -->|CRUD| DS2

    %% Connections - Process 3.0
    E_P -->|Cari & Booking| P3
    DS2 -->|Info Ketersediaan| P3
    P3 -->|Simpan Transaksi| DS3
    DS3 -->|Validasi Kursi| P3
    E_A -->|Validasi Bayar| P3
    P3 -->|Tiket Terbit| E_P

    %% Connections - Process 4.0
    E_A -->|Request Laporan| P4
    DS3 -->|Ambil Data Transaksi| P4
    P4 -->|Laporan Harian/Bulanan| E_A
```

---

## 3. Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    USERS {
        int id PK
        string name
        string email
        string password
        string role "admin/driver/customer"
    }

    RUTE {
        int id PK
        string kota_asal
        string kota_tujuan
        int harga
        string estimasi_waktu
    }

    ARMADA {
        int id PK
        string nama_armada
        string plat_nomor
        string layout_kursi
    }

    JADWAL {
        int id PK
        int rute_id FK
        time jam_berangkat
        json hari_aktif
        enum status
    }

    PERJALANAN {
        int id PK
        int jadwal_id FK
        date tanggal
        int armada_id FK
        int driver_id FK
        enum status
    }

    PEMESANAN {
        string id PK
        int customer_id FK
        int perjalanan_id FK
        int total_harga
        enum status_pembayaran
        datetime created_at
    }

    PEMESANAN_SEAT {
        int id PK
        string pemesanan_id FK
        string nomor_kursi
        string nama_penumpang
    }

    %% Relationships
    USERS ||--o{ PEMESANAN : "makes (customer)"
    USERS ||--o{ PERJALANAN : "drives (driver)"
    
    RUTE ||--o{ JADWAL : "has"
    JADWAL ||--o{ PERJALANAN : "generates instance"
    ARMADA ||--o{ PERJALANAN : "assigned to"
    
    PERJALANAN ||--o{ PEMESANAN : "contains"
    PEMESANAN ||--|{ PEMESANAN_SEAT : "includes"
```

---

## 4. Use Case Diagram

```mermaid
usecaseDiagram
    actor "Passenger" as P
    actor "Admin" as A
    actor "Driver" as D

    package "Raaster Shuttle System" {
        usecase "Login / Registrasi" as UC1
        usecase "Cari Jadwal" as UC2
        usecase "Pesan Tiket & Pilih Kursi" as UC3
        usecase "Pembayaran" as UC4
        usecase "Kelola Rute & Jadwal" as UC5
        usecase "Kelola Armada" as UC6
        usecase "Lihat Laporan" as UC7
        usecase "Update Lokasi / Status" as UC8
        usecase "Lihat Manifes" as UC9
    }

    %% Passenger
    P --> UC1
    P --> UC2
    P --> UC3
    UC3 ..> UC2 : <<include>>
    P --> UC4

    %% Admin
    A --> UC1
    A --> UC5
    A --> UC6
    A --> UC4 : "Validasi"
    A --> UC7

    %% Driver
    D --> UC1
    D --> UC8
    D --> UC9
```

---

## 5. Activity Diagram (Alur Pemesanan Tiket)

```mermaid
flowchart TD
    Start((Mulai)) --> Login{Sudah Login?}
    
    %% Not Logged In
    Login -- Tidak --> FormLogin[Input Username & Password]
    FormLogin --> ValidasiUser{Valid?}
    ValidasiUser -- Tidak --> FormLogin
    ValidasiUser -- Ya --> Dashboard

    %% ByPass
    Login -- Ya --> Dashboard

    %% Booking Flow
    Dashboard --> Cari[Cari Rute & Tanggal]
    Cari --> ListJadwal[Tampil Daftar Jadwal]
    ListJadwal --> Pilih[Pilih Jadwal]
    Pilih --> CekFull{Kursi Tersedia?}
    
    CekFull -- Tidak --> Cari
    CekFull -- Ya --> PilihKursi[Pilih Nomor Kursi]
    
    PilihKursi --> IsiData[Isi Data Penumpang]
    IsiData --> Checkout[Checkout & Pembayaran]
    
    Checkout --> Verifikasi{Verifikasi Admin/Sistem}
    Verifikasi -- Gagal/Timeout --> Batal[Pemesanan Dibatalkan]
    Batal --> End((Selesai))
    
    Verifikasi -- Sukses --> Terbit[Terbit E-Ticket & Status Lunas]
    Terbit --> End
```

---

## 6. Class Diagram

```mermaid
classDiagram
    class Users {
        +int id
        +string name
        +string email
        +string password
        +string role
        +login()
        +register()
        +updateProfile()
    }

    class Rute {
        +int id
        +string kota_asal
        +string kota_tujuan
        +int harga
        +getRoutes()
    }

    class Jadwal {
        +int id
        +int rute_id
        +time jam_berangkat
        +getSchedules()
    }

    class Armada {
        +int id
        +string nama_armada
        +string plat_nomor
        +string layout_kursi
    }

    class Perjalanan {
        +int id
        +date tanggal
        +int driver_id
        +getSeatAvailability()
    }

    class Pemesanan {
        +string id
        +int customer_id
        +int total_harga
        +string status
        +createBooking()
        +cancelBooking()
    }

    %% Relations
    Users "1" -- "0..*" Pemesanan : makes
    Rute "1" -- "0..*" Jadwal : defines
    Jadwal "1" -- "0..*" Perjalanan : generates
    Armada "1" -- "0..*" Perjalanan : executes
    Perjalanan "1" -- "0..*" Pemesanan : has
```

---

## 7. Sequence Diagram (Proses Booking Tiket)

```mermaid
sequenceDiagram
    actor User as Passenger
    participant View as Halaman Booking
    participant Ctrl as Booking Controller
    participant Model as Booking Model
    participant DB as Database

    %% 1. PENCARIAN JADWAL
    User->>View: Cari Jadwal (Asal, Tujuan, Tanggal)
    activate View
    View->>Ctrl: GET search(asal, tujuan, tanggal)
    activate Ctrl
    Ctrl->>Model: search_jadwal(asal, tujuan, tanggal)
    activate Model
    Model->>DB: SELECT * FROM jadwal JOIN rute...
    activate DB
    DB-->>Model: Result Set (Jadwal List)
    deactivate DB
    Model-->>Ctrl: Array of Objects (Jadwal)
    deactivate Model
    Ctrl-->>View: Load View (search_result, data)
    deactivate Ctrl
    View-->>User: Tampilkan Daftar Jadwal
    deactivate View

    %% 2. PEMILIHAN KURSI
    User->>View: Klik "Pilih Kursi" pada Jadwal
    activate View
    View->>Ctrl: GET select_seat(jadwal_id)
    activate Ctrl
    
    par Get Detail & Seats
        Ctrl->>Model: get_jadwal_detail(jadwal_id)
        activate Model
        Model->>DB: SELECT JOIN rute, armada...
        activate DB
        DB-->>Model: Row Object
        deactivate DB
        Model-->>Ctrl: Data Jadwal
        deactivate Model
    and Get Booked Seats
        Ctrl->>Model: get_booked_seats(jadwal_id, tanggal)
        activate Model
        Model->>DB: SELECT nomor_kursi FROM pemesanan_seat...
        activate DB
        DB-->>Model: Array (['1A', '2B'])
        deactivate DB
        Model-->>Ctrl: Booked Seats Array
        deactivate Model
    end

    Ctrl-->>View: Load View (select_seat, data)
    deactivate Ctrl
    View-->>User: Tampilkan Layout Kursi (Merah=Terisi)
    deactivate View

    %% 3. PROSES BOOKING
    User->>View: Pilih Kursi & Klik "Lanjut Pemesanan"
    activate View
    View->>Ctrl: POST process_booking(seats, data_diri)
    activate Ctrl
    
    Ctrl->>Ctrl: Validate Input (seats not empty)
    
    Ctrl->>Model: create_booking(data_pemesanan, seats)
    activate Model
    
    Note right of Model: Start Transaction
    
    Model->>DB: Check/Create Perjalanan (jadwal_id, tanggal)
    activate DB
    DB-->>Model: perjalanan_id
    deactivate DB

    Model->>DB: INSERT INTO pemesanan
    activate DB
    DB-->>Model: Insert ID
    deactivate DB

    loop For Each Seat
        Model->>DB: INSERT INTO pemesanan_seat
        activate DB
        DB-->>Model: Success
        deactivate DB
    end
    
    Note right of Model: Commit Transaction (if success)
    
    Model-->>Ctrl: Return booking_id
    deactivate Model

    alt Booking Success
        Ctrl-->>View: Redirect('booking/payment/id')
        View-->>User: Halaman Pembayaran
    else Booking Failed
        Ctrl-->>View: Redirect Back with Flashdata Error
        View-->>User: Tampilkan Pesan Error
    end
    deactivate Ctrl
    deactivate View
```

---
