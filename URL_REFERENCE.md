# URL Reference Guide - Girls Hostel Mess Management System

## 🔑 Authentication URLs

### Login Page (Shared for Admin & Student)
```
http://localhost:8081/login
or
http://localhost:8081/
```

**There is NO separate `/admin/login` or `/student/login`**

The system uses a single login page. After authentication, users are automatically redirected based on their role:
- **Admin users** → redirected to `/admin/dashboard`
- **Student users** → redirected to `/student/dashboard`

### Logout
```
http://localhost:8081/logout
```

---

## 👨‍💼 Admin URLs (After Login)

### Main
- Dashboard: `/admin/dashboard`

### Student Management
- List: `/admin/students`
- Add: `/admin/students/add`
- View: `/admin/students/view/{id}`
- Edit: `/admin/students/edit/{id}`

### KYC Management
- All: `/admin/kyc`
- Pending: `/admin/kyc/pending`
- Verified: `/admin/kyc/verified`
- Rejected: `/admin/kyc/rejected`

### Menu Management
- All: `/admin/menus`
- Weekly: `/admin/menus/weekly`
- Add: `/admin/menus/add`

### Holiday Management
- All: `/admin/holidays`
- Add: `/admin/holidays/add`

### Extra Meal Requests
- All: `/admin/extra-meals`
- Pending: `/admin/extra-meals/pending`
- Approved: `/admin/extra-meals/approved`

### Payments
- All: `/admin/payments`
- Pending: `/admin/payments/pending`
- Paid: `/admin/payments/paid`
- Generate Fees: `/admin/payments/generate-fees`

### Reports
- Dashboard: `/admin/reports`
- Students: `/admin/reports/students`
- Payments: `/admin/reports/payments`
- Extra Meals: `/admin/reports/extra-meals`

### Settings
- Profile: `/admin/settings/profile`

---

## 👩‍🎓 Student URLs (After Login)

### Main
- Dashboard: `/student/dashboard`

### Profile
- View: `/student/profile`
- Edit: `/student/profile/edit`

### Parents
- View: `/student/parents`
- Edit: `/student/parents/edit`

### KYC
- Status: `/student/kyc`
- Upload: `/student/kyc/upload`

### Menu
- View: `/student/menu`
- Weekly: `/student/menu/weekly`
- Today: `/student/menu/today`

### Holidays
- View: `/student/holidays`

### Extra Meals
- Overview: `/student/extra-meals`
- Request: `/student/extra-meals/request`
- History: `/student/extra-meals/history`

### Payments
- Overview: `/student/payments`
- Current: `/student/payments/current`
- History: `/student/payments/history`

### Settings
- Account: `/student/settings`

---

## 🔐 Default Login Credentials

**Admin:**
- Email: `admin@hostelmess.com`
- Password: `admin123`

---

## ⚠️ Common Mistakes

❌ **WRONG:**
- `http://localhost:8081/admin/login` (doesn't exist)
- `http://localhost:8081/student/login` (doesn't exist)

✅ **CORRECT:**
- `http://localhost:8081/login` (single login for all users)

---

## 🔄 Login Flow

1. User visits `/login`
2. Enters email & password
3. System authenticates and checks role
4. **If Admin** → Redirect to `/admin/dashboard`
5. **If Student** → Redirect to `/student/dashboard`

---

## 🛡️ Route Protection

All admin routes require:
- User must be logged in
- User role must be `admin`

All student routes require:
- User must be logged in
- User role must be `student`

If you try to access a protected route without proper authentication/authorization, you'll be redirected to the login page.