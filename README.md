# **Smart Accounting Software**

## **Introduction**
This project is a robust **Accounting Software** designed to simplify financial management for businesses of all sizes. It offers an intuitive system for handling companies, users, roles, permissions, and financial documents like invoices and quotations. 

Built using **Laravel** and **FilamentPHP**, this application is tailored to be highly modular, secure, and user-friendly, ensuring businesses can focus on their operations while leaving the accounting complexities to the software.

---

## **Key Features**
- **Multi-Company Management**: Manage multiple companies seamlessly in a single system.
- **User Management**: Add multiple users per company with tailored roles and permissions.
- **Role-Based Access Control (RBAC)**: Define and assign roles with specific permissions for users.
- **Document Management**: Generate and manage key financial documents:
  - **Invoices**
  - **Proforma Invoices**
  - **Quotations**
- **Dynamic Address Management**: Store structured business addresses for companies and users.
- **Customizable Permissions**: Granular control over user access and actions.
- **Pre-Sales & Accounting Integration**: Manage sales and accounting documents efficiently.

---

## **Modules**
### **1. Company Management**
- Register and manage multiple companies.
- Fields include:
  - Name
  - Industry
  - Registration Number
  - Business Address (stored as structured JSON)
  - Contact Details

### **2. User Management**
- Add, update, and manage company users.
- Fields include:
  - Full Name
  - Email
  - Password
  - Associated Company
  - Assigned Role

### **3. Role Management**
- Create company-specific roles with tailored permissions.
- Example roles:
  - Admin
  - Accountant
  - Manager
  - Sales Representative

### **4. Permission Management**
- Define granular permissions for roles.
- Permissions include:
  - Manage Invoices
  - View Reports
  - Modify Company Details
  - Create Quotations
  - Handle User Access

### **5. Financial Document Management**
- **Quotations**:
  - Create and manage pre-sales quotations for clients.
  - Convert quotations into invoices when approved.
- **Proforma Invoices**:
  - Generate detailed proforma invoices for prospective sales.
- **Invoices**:
  - Manage invoices with statuses (e.g., Paid, Pending, Overdue).
  - Automatically calculate totals, taxes, and discounts.

