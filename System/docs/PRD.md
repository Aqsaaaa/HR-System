<style>
:root{--bg:#ffffff;--text:#1a1a2e;--heading:#0f0f1a;--border:#e2e8f0;--accent:#3b82f6;--accent2:#6366f1;--code-bg:#f1f5f9;--blockquote-bg:#f8fafc;--blockquote-border:#3b82f6;--table-header-bg:#f1f5f9;--table-row-even:#f8fafc;--table-border:#e2e8f0;--muted:#64748b;--badge-bg:#e0e7ff;--badge-text:#4338ca;--success:#10b981;--warning:#f59e0b;--danger:#ef4444}
@media(prefers-color-scheme:dark){
:root{--bg:#0f172a;--text:#e2e8f0;--heading:#f1f5f9;--border:#1e293b;--accent:#60a5fa;--accent2:#818cf8;--code-bg:#1e293b;--blockquote-bg:#0f172a;--blockquote-border:#60a5fa;--table-header-bg:#1e293b;--table-row-even:#0f172a;--table-border:#1e293b;--muted:#94a3b8;--badge-bg:#1e1b4b;--badge-text:#a5b4fc;--success:#34d399;--warning:#fbbf24;--danger:#f87171}
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;background:var(--bg);color:var(--text);line-height:1.7;max-width:1100px;margin:0 auto;padding:2rem;transition:background .3s,color .3s}
h1,h2,h3,h4,h5,h6{color:var(--heading);font-weight:600;line-height:1.3;margin-top:2em;margin-bottom:.5em}
h1{font-size:2.5em;border-bottom:2px solid var(--accent);padding-bottom:.3em}
h2{font-size:1.8em;border-bottom:1px solid var(--border);padding-bottom:.2em}
h3{font-size:1.4em;color:var(--accent)}
h4{font-size:1.15em;color:var(--accent2)}
a{color:var(--accent);text-decoration:none}
a:hover{text-decoration:underline}
code{background:var(--code-bg);padding:.15em .4em;border-radius:4px;font-size:.9em;font-family:'SF Mono','Fira Code','Consolas',monospace}
pre{background:var(--code-bg);border:1px solid var(--border);border-radius:8px;padding:1em;overflow-x:auto;font-size:.9em;line-height:1.5}
pre code{background:none;padding:0}
blockquote{border-left:4px solid var(--blockquote-border);background:var(--blockquote-bg);margin:1.5em 0;padding:.8em 1.2em;border-radius:0 8px 8px 0}
table{width:100%;border-collapse:collapse;margin:1.5em 0;font-size:.9em;border-radius:8px;overflow:hidden;border:1px solid var(--table-border)}
th{background:var(--table-header-bg);font-weight:600;text-align:left;padding:.75em 1em;border-bottom:2px solid var(--border)}
td{padding:.65em 1em;border-bottom:1px solid var(--border)}
tr:nth-child(even) td{background:var(--table-row-even)}
hr{border:none;border-top:1px solid var(--border);margin:2em 0}
img{max-width:100%;border-radius:8px;border:1px solid var(--border)}
ul,ol{padding-left:1.5em}
li{margin:.3em 0}
.badge{display:inline-block;background:var(--badge-bg);color:var(--badge-text);padding:.15em .6em;border-radius:12px;font-size:.8em;font-weight:500;margin-right:.5em}
.toc{background:var(--blockquote-bg);border:1px solid var(--border);border-radius:8px;padding:1.2em 1.5em;margin:2em 0}
.toc ul{list-style:none;padding-left:0}
.toc li{margin:.4em 0}
.toc a{color:var(--text)}
.toc a:hover{color:var(--accent)}
.info-box{background:var(--blockquote-bg);border:1px solid var(--border);border-left:4px solid var(--accent);border-radius:8px;padding:1em 1.2em;margin:1.5em 0}
.info-box strong{color:var(--accent)}
</style>

# Enterprise HRIS Platform — Product Requirements Document

<div class="badge">Version 1.0</div>
<div class="badge">Status: Draft</div>
<div class="badge">Last Updated: July 2026</div>

---

## Table of Contents

<div class="toc">

1. [Executive Summary](#1-executive-summary)
2. [Product Vision](#2-product-vision)
3. [User Personas](#3-user-personas)
4. [Feature List](#4-feature-list)
5. [Functional Requirements](#5-functional-requirements)
6. [Non-Functional Requirements](#6-non-functional-requirements)
7. [Entity Relationship Diagram](#7-entity-relationship-diagram)
8. [Database Schema](#8-database-schema)
9. [API Endpoint Design](#9-api-endpoint-design)
10. [Folder Structure](#10-folder-structure)
11. [Laravel Architecture](#11-laravel-architecture)
12. [Service Layer](#12-service-layer)
13. [Repository Pattern](#13-repository-pattern)
14. [Queue & Job Flow](#14-queue--job-flow)
15. [Scheduler Flow](#15-scheduler-flow)
16. [Sequence Diagrams](#16-sequence-diagrams)
17. [Activity Diagrams](#17-activity-diagrams)
18. [Permission Matrix](#18-permission-matrix)
19. [UI Wireframe Descriptions](#19-ui-wireframe-descriptions)
20. [Development Roadmap](#20-development-roadmap)

</div>

---

# 1. Executive Summary

## 1.1 Document Purpose

This Product Requirements Document (PRD) defines the complete specification for an **Enterprise Human Resource Information System (HRIS)** platform. It serves as the single source of truth for all stakeholders — product managers, engineering teams, QA, DevOps, and business owners — throughout the development lifecycle.

## 1.2 Product Overview

The Enterprise HRIS is a **modular, cloud-native, role-based** platform designed to centralize and automate the entire employee lifecycle management. From recruitment to offboarding, attendance to payroll, performance reviews to analytics — every HR function is unified under a single, secure, scalable system.

## 1.3 Business Goals

| Goal | Description | KPI |
|------|-------------|-----|
| Operational Efficiency | Reduce manual HR tasks by 70% | Time saved per HR transaction |
| Data Centralization | Eliminate data silos | Single source of truth adoption |
| Compliance | Audit-ready records for all activities | 100% audit trail coverage |
| Employee Experience | Self-service for all employees | eNPS > 60 |
| Cost Reduction | Reduce HR ops cost by 40% | Cost per employee per year |
| Scalability | 10,000+ concurrent users < 200ms | P95 API response time |

## 1.4 Scope

### In Scope

- Full employee lifecycle management
- Role-based access control with granular permissions
- Attendance tracking and leave management
- Payroll processing with tax calculations
- Recruitment pipeline management
- Performance review cycles
- Real-time notifications and announcements
- Comprehensive audit logging
- Advanced analytics and customizable reports
- Import/Export for all data entities
- API-first design for future integrations

### Out of Scope (Phase 2+)

- Third-party payroll provider integrations
- Mobile native applications (PWA first)
- Biometric device hardware integration
- Advanced AI-driven candidate matching
- Learning Management System
- Employee wellness and benefits administration

## 1.5 Key Stakeholders

| Stakeholder | Role | Interest |
|-------------|------|----------|
| CHRO / HR Director | Business Owner | Strategic workforce decisions |
| HR Operations | Primary User | Day-to-day HR process execution |
| HR Managers | Power User | Team management and approvals |
| Employees | End User | Self-service portal access |
| Finance Team | Secondary User | Payroll and budget management |
| IT / Security | Technical Owner | System security and integration |
| Engineering Team | Builder | Implementation and maintenance |

## 1.6 Success Metrics

| Metric | Target | Measurement |
|--------|--------|-------------|
| System Uptime | 99.9% | Monthly uptime report |
| API Response Time | < 200ms (P95) | APM monitoring |
| User Adoption Rate | > 85% in 6 months | Active user analytics |
| Data Entry Errors | < 1% of transactions | Validation success rate |
| Report Generation | < 5 seconds for standard reports | Performance monitoring |
| Audit Completeness | 100% of critical actions logged | Audit log coverage test |

---

# 2. Product Vision

## 2.1 Vision Statement

> **"To become the most intuitive, intelligent, and inclusive HR operating system for mid-to-large enterprises — where every people operation is effortless, every insight is actionable, and every employee feels valued."**

## 2.2 Strategic Pillars

### Pillar 1: Unified HR Operations
- Single platform covering the entire employee lifecycle
- Seamless data flow across all modules
- Eliminate redundant data entry and manual reconciliation

### Pillar 2: Intelligent Automation
- Automated approval workflows
- Smart scheduling and attendance tracking
- Payroll calculations with zero manual intervention

### Pillar 3: Data-Driven Decisions
- Real-time dashboards for HR and leadership
- Predictive analytics for retention and hiring
- Custom report builder for ad-hoc analysis

### Pillar 4: Enterprise-Grade Security
- Role-based access with field-level permissions
- Complete audit trail for every transaction
- SOC 2 and GDPR compliance ready

## 2.3 Target Market

| Segment | Description | Company Size |
|---------|-------------|--------------|
| Mid-Market | Growing companies needing structured HR | 200-1,000 employees |
| Enterprise | Large organizations with complex hierarchies | 1,000-10,000+ employees |
| Multi-National | Companies operating across multiple countries | 5,000+ employees |

## 2.4 Competitive Landscape

| Competitor | Strengths | Weaknesses | Our Advantage |
|------------|-----------|------------|---------------|
| BambooHR | UX, simplicity | Limited payroll, weak analytics | Full suite + better analytics |
| Gusto | Payroll, benefits | US-only, small business | Enterprise scale + multi-country |
| Workday | Enterprise, AI | Expensive, complex | Cost-effective + faster deployment |
| SAP SuccessFactors | Compliance, global | Legacy UX, high TCO | Modern architecture, better UX |
| Zoho People | Affordable, modular | Limited integrations, basic reports | Better API, stronger security |

---

# 3. User Personas

## 3.1 Persona A: Sarah — HR Operations Manager

| Attribute | Detail |
|-----------|--------|
| Age | 34 |
| Role | HR Operations Manager |
| Experience | 8 years in HR |
| Tech Literacy | Medium |
| Location | On-site / Hybrid |

### Goals
- Process employee data changes quickly
- Run monthly payroll without errors
- Generate compliance reports for auditors
- Respond to employee inquiries with accurate data

### Pain Points
- Switching between multiple systems (payroll, attendance, recruitment)
- Manual data reconciliation between modules
- Late night payroll calculations
- Difficulty finding historical employee records

### User Stories
- "As an HR Operations Manager, I want to view an employee's complete lifecycle in one place so I can answer any query immediately."
- "As an HR Operations Manager, I want to run payroll with one click so I don't waste hours on manual calculations."
- "As an HR Operations Manager, I want to see who's on leave today so I can plan team coverage."

## 3.2 Persona B: Alex — Employee

| Attribute | Detail |
|-----------|--------|
| Age | 28 |
| Role | Software Engineer |
| Experience | 4 years |
| Tech Literacy | High |
| Location | Remote |

### Goals
- Request leave and see remaining balance instantly
- View and download payslips
- Update personal information
- Submit timesheets when working remotely

### Pain Points
- Paper-based leave forms that get lost
- Not knowing how many leave days remain
- Complicated login process
- No way to see colleague contact info

### User Stories
- "As an Employee, I want to request annual leave in under 30 seconds so I can plan my time off."
- "As an Employee, I want to receive a notification when my leave is approved so I don't have to keep checking."
- "As an Employee, I want to see my payslip digitally so I can access it anytime."

## 3.3 Persona C: Michael — Department Manager

| Attribute | Detail |
|-----------|--------|
| Age | 42 |
| Role | Engineering Director |
| Experience | 18 years (10 as manager) |
| Tech Literacy | Medium-High |
| Location | On-site |

### Goals
- Approve or reject team leave requests quickly
- View team attendance and performance metrics
- Submit performance reviews for direct reports
- Access department budget and headcount reports

### Pain Points
- Too many approval emails cluttering inbox
- No visibility into team availability
- Performance review process takes too long
- Can't see department spending on payroll

### User Stories
- "As a Manager, I want to approve or reject leave requests from my mobile so I can manage my team on the go."
- "As a Manager, I want to see my team's attendance trends so I can identify issues early."
- "As a Manager, I want to submit performance reviews with structured feedback so reviews are fair and consistent."

## 3.4 Persona D: Jessica — Finance Manager

| Attribute | Detail |
|-----------|--------|
| Age | 38 |
| Role | Finance Manager |
| Experience | 12 years in finance |
| Tech Literacy | Medium |
| Location | On-site |

### Goals
- Process payroll accurately and on time
- Reconcile payroll with general ledger
- Track department-wise budget vs actual spend
- Generate tax reports for statutory compliance

### Pain Points
- Payroll errors due to manual data entry
- Late attendance data from multiple departments
- Difficulty tracking payroll adjustments
- No integration with accounting system

### User Stories
- "As a Finance Manager, I want payroll to be calculated automatically based on attendance data so I eliminate manual errors."
- "As a Finance Manager, I want to see payroll history by month so I can track budget trends."
- "As a Finance Manager, I want to export payroll reports in a format my accounting software accepts."

## 3.5 Persona E: David — Super Admin / CTO

| Attribute | Detail |
|-----------|--------|
| Age | 45 |
| Role | CTO / System Owner |
| Experience | 20 years in tech |
| Tech Literacy | Very High |
| Location | Anywhere |

### Goals
- Ensure system security and compliance
- Configure roles, permissions, and access control
- Monitor system performance and uptime
- Plan system architecture and integrations

### Pain Points
- Managing user access manually
- Security compliance requirements (SOC 2, GDPR)
- System performance degradation during peak usage
- Keeping the system updated with minimal downtime

### User Stories
- "As a Super Admin, I want to configure granular permissions per role so I enforce the principle of least privilege."
- "As a Super Admin, I want to view the complete audit log so I can investigate any security incident."
- "As a Super Admin, I want to receive system health alerts so I can respond to issues before they affect users."

---

# 4. Feature List

## 4.1 Feature Overview Matrix

| Module | Features | Priority | Complexity |
|--------|----------|----------|------------|
| Authentication | Login, MFA, SSO, Forgot Password, Profile | P0 | Medium |
| Dashboard | Personal, Manager, HR, Admin Dashboards | P0 | Medium |
| Employee | CRUD, Profile, Documents, History, Import/Export | P0 | High |
| Department | CRUD, Hierarchy, Budget, Headcount | P0 | Low |
| Position | CRUD, Job Specs, Skills Matrix, Career Path | P0 | Low |
| Attendance | Clock In/Out, Timesheet, Schedule, Geolocation | P0 | High |
| Leave | Request, Balance, Calendar, Approval Workflow | P0 | High |
| Payroll | Run Payroll, Payslip, Tax, Benefits, History | P0 | Critical |
| Recruitment | Job Posting, Application, Pipeline, Offer | P1 | High |
| Performance Review | Review Cycle, Self/Peer/Manager Review, KPI | P1 | High |
| Announcement | Create, Publish, Target Audience, Archive | P1 | Low |
| Notification | In-App, Email, Push, Preferences | P0 | Medium |
| Settings | Company Profile, Roles, Permissions, Workflow | P0 | Medium |
| Audit Log | Activity Log, Change History, Export | P0 | Medium |
| Report | Custom Report Builder, Export, Scheduling | P1 | High |
| Analytics | Dashboards, Trends, Predictive | P1 | High |

## 4.2 Priority Framework

- **P0 — Critical**: Must-have for MVP launch. System cannot function without these.
- **P1 — High**: Important for user adoption and value. Included in V1 release.
- **P2 — Medium**: Enhances user experience. Planned for V2.
- **P3 — Low**: Future innovation. Not yet committed.

## 4.3 MVP Scope (P0 + P1)

```
MVP = Authentication + Dashboard + Employee + Department + Position
    + Attendance + Leave + Payroll + Notification + Settings + Audit Log
```
# 5. Functional Requirements

## 5.1 Authentication Module

### 5.1.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| AUTH-01 | User | Log in with email and password | I can access the system securely |
| AUTH-02 | User | Log in with Single Sign-On (SSO) | I don't need to remember another password |
| AUTH-03 | User | Reset my password via email | I can regain access if I forget my credentials |
| AUTH-04 | User | Enable Two-Factor Authentication (2FA) | My account is more secure |
| AUTH-05 | User | View and update my profile | My information is current |
| AUTH-06 | User | Log out from all devices | My session is terminated if my device is lost |
| AUTH-07 | Admin | Configure SSO settings | The organization can use its identity provider |
| AUTH-08 | Admin | Force password reset for users | Security policies are enforced |
| AUTH-09 | User | See my active sessions | I can monitor where I'm logged in |

### 5.1.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| AUTH-BR01 | Max 5 failed login attempts before account is locked for 15 minutes |
| AUTH-BR02 | Password: min 12 chars, uppercase, lowercase, number, special char |
| AUTH-BR03 | Session timeout after 60 minutes of inactivity |
| AUTH-BR04 | Password expires every 90 days |
| AUTH-BR05 | Cannot reuse last 5 passwords |
| AUTH-BR06 | 2FA code expires after 5 minutes |
| AUTH-BR07 | SSO login bypasses password policy but not 2FA |
| AUTH-BR08 | Inactive accounts auto-disabled after 90 days |
| AUTH-BR09 | Max 3 concurrent sessions per user |

### 5.1.3 Validation Rules

| Field | Rule | Error Message |
|-------|------|---------------|
| email | required, email, max:255 | A valid email address is required. |
| password | required, min:12, confirmed | Password must be at least 12 characters. |
| current_password | required when changing password | Current password is required. |
| 2fa_code | required when 2FA enabled, digits:6 | A valid 6-digit code is required. |

### 5.1.4 API Design

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| POST | /api/auth/login | User login | None |
| POST | /api/auth/login/sso | SSO login | None |
| POST | /api/auth/logout | Logout current session | Sanctum |
| POST | /api/auth/logout/all | Logout all sessions | Sanctum |
| POST | /api/auth/forgot-password | Send password reset link | None |
| POST | /api/auth/reset-password | Reset password with token | None |
| POST | /api/auth/refresh | Refresh session token | Sanctum |
| GET | /api/auth/profile | Get authenticated user profile | Sanctum |
| PUT | /api/auth/profile | Update profile | Sanctum |
| PUT | /api/auth/password | Change password | Sanctum |
| POST | /api/auth/2fa/enable | Enable 2FA | Sanctum |
| POST | /api/auth/2fa/disable | Disable 2FA | Sanctum |
| POST | /api/auth/2fa/verify | Verify 2FA code | Sanctum |
| GET | /api/auth/sessions | List active sessions | Sanctum |
| DELETE | /api/auth/sessions/{id} | Terminate specific session | Sanctum |

### 5.1.5 Database Schema

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255),
    avatar VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    timezone VARCHAR(50) DEFAULT 'UTC',
    locale VARCHAR(10) DEFAULT 'en',
    email_verified_at TIMESTAMP NULL,
    two_factor_secret TEXT NULL,
    two_factor_recovery_codes TEXT NULL,
    two_factor_confirmed_at TIMESTAMP NULL,
    last_login_at TIMESTAMP NULL,
    last_login_ip VARCHAR(45) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    must_change_password BOOLEAN DEFAULT FALSE,
    password_changed_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_users_email (email),
    INDEX idx_users_employee_id (employee_id),
    INDEX idx_users_is_active (is_active)
);

CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) UNIQUE NOT NULL,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tokens_tokenable (tokenable_type, tokenable_id)
);

CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX idx_sessions_user_id (user_id),
    INDEX idx_sessions_last_activity (last_activity)
);
```

### 5.1.6 Relationships

User (1) --- (N) PersonalAccessToken
User (1) --- (N) Session
User (1) --- (1) Employee (optional, polymorphic)

### 5.1.7 CRUD Flow

POST /api/auth/login
  -> Validate credentials
  -> Check is_active status
  -> Check account lockout
  -> Verify 2FA if enabled
  -> Create Sanctum token
  -> Log audit: user.login
  -> Return token + user data

POST /api/auth/logout
  -> Revoke current token
  -> Log audit: user.logout
  -> Return success

PUT /api/auth/profile
  -> Validate input
  -> Update user record
  -> Log audit: user.profile.updated
  -> Return updated profile

### 5.1.8 Search, Filter, Pagination

| Parameter | Type | Description |
|-----------|------|-------------|
| search | string | Search by name or email |
| is_active | boolean | Filter by active status |
| role | string | Filter by role |
| department_id | int | Filter by department |
| per_page | int | Items per page (default: 15, max: 100) |
| page | int | Page number |
| sort | string | Sort field |
| direction | string | Sort direction |

### 5.1.9 Import / Export

| Feature | Description |
|---------|-------------|
| Import Users | CSV/Excel bulk user creation with validation |
| Export Users | CSV/Excel export of user list |
| Import Template | Downloadable template with headers and rules |

### 5.1.10 Audit Trail

| Event | Description | Data Captured |
|-------|-------------|---------------|
| user.login | User logged in | IP, user_agent, timestamp |
| user.logout | User logged out | IP, timestamp |
| user.login.failed | Failed login attempt | IP, attempted email, timestamp |
| user.password.changed | Password changed | Timestamp |
| user.profile.updated | Profile updated | Changed fields (old -> new) |
| user.2fa.enabled | 2FA enabled | Timestamp |
| user.2fa.disabled | 2FA disabled | Timestamp |

---

## 5.2 Dashboard Module

### 5.2.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| DASH-01 | Employee | See my attendance today and leave balance | I can quickly check my status |
| DASH-02 | Employee | See upcoming birthdays and anniversaries | I can celebrate with colleagues |
| DASH-03 | Employee | See pending tasks (leave requests, reviews) | I know what needs my attention |
| DASH-04 | Manager | See my team's attendance summary | I can monitor team availability |
| DASH-05 | Manager | See pending approval requests | I can process them quickly |
| DASH-06 | HR | See key HR metrics (headcount, turnover) | I can report to leadership |
| DASH-07 | HR | See recent announcements | I stay informed |
| DASH-08 | Admin | See system health and activity | I can monitor system status |

### 5.2.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| DASH-BR01 | Dashboard content is role-based and permission-driven |
| DASH-BR02 | Widgets are configurable (show/hide/reorder) |
| DASH-BR03 | Real-time data with max 5-minute cache for metrics |
| DASH-BR04 | Manager sees only direct reports (not entire org unless permission granted) |

### 5.2.3 Dashboard Widgets

| Widget | Roles | Data Source |
|--------|-------|-------------|
| Clock In/Out Button | Employee, Manager | Attendance |
| Today's Attendance | Employee, Manager | Attendance |
| Leave Balance | Employee | Leave |
| Pending Approvals | Manager, HR | Leave, Attendance |
| Upcoming Holidays | All | Settings -> Holidays |
| Team Attendance | Manager | Attendance |
| Headcount Overview | HR, Admin | Employee |
| Recent Announcements | All | Announcement |
| My Tasks | All | Leave, Performance Review |
| Quick Actions | All | Various |
| System Health | Admin | Monitoring |

### 5.2.4 API Design

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /api/dashboard | Get user's dashboard data | Sanctum |
| GET | /api/dashboard/widgets | List available widgets | Sanctum |
| PUT | /api/dashboard/widgets | Update widget configuration | Sanctum |
| GET | /api/dashboard/metrics | Get HR metrics (HR/Admin) | Sanctum |

### 5.2.5 Database Schema

No additional tables — dashboard aggregates data from other modules.

### 5.2.6 CRUD Flow

GET /api/dashboard
  -> Identify user role
  -> Determine visible widgets
  -> Aggregate data from relevant modules
  -> Apply caching (5 min TTL)
  -> Return dashboard payload

---

## 5.3 Employee Module

### 5.3.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| EMP-01 | HR | Create a new employee record | I can onboard new hires |
| EMP-02 | HR | View all employees with search and filters | I can find employee information quickly |
| EMP-03 | HR | Update employee details | I can maintain accurate records |
| EMP-04 | HR | Terminate an employee record | I can process offboarding |
| EMP-05 | HR | Upload employee documents | I can store documents digitally |
| EMP-06 | HR | Import employees from CSV | I can bulk onboard |
| EMP-07 | HR | Export employee data | I can share data with auditors |
| EMP-08 | Employee | View my own profile | I can see my information |
| EMP-09 | Employee | Update my personal details | I keep my info current |
| EMP-10 | Manager | View my team members' profiles | I know my team |

### 5.3.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| EMP-BR01 | Employee ID is auto-generated (format: EMP-{YYYY}-{XXXX}) |
| EMP-BR02 | Email must be unique across all users (including inactive) |
| EMP-BR03 | Employee must belong to a department and position |
| EMP-BR04 | An employee can only have one active record at a time |
| EMP-BR05 | Personal email is stored separately from company email |
| EMP-BR06 | Sensitive fields (salary, bank details) have field-level permissions |
| EMP-BR07 | Employee can view but not edit: department, position, salary, employment type |
| EMP-BR08 | Document uploads are limited to 10MB per file |
| EMP-BR09 | Employee status lifecycle: Active -> Resigned -> Terminated |
| EMP-BR10 | Rehired employees get a new employee ID |

### 5.3.3 Validation Rules

| Field | Rule | Error Message |
|-------|------|---------------|
| first_name | required, max:255 | First name is required. |
| last_name | required, max:255 | Last name is required. |
| email | required, email, unique:employees | This email is already registered. |
| phone | nullable, regex | Invalid phone number format. |
| department_id | required, exists:departments,id | Please select a valid department. |
| position_id | required, exists:positions,id | Please select a valid position. |
| hire_date | required, date, before_or_equal:today | Hire date cannot be in the future. |
| salary | required_if:permanent, numeric, min:0 | Salary must be a positive number. |

### 5.3.4 API Design

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | /api/employees | List employees (paginated) | Sanctum |
| POST | /api/employees | Create employee | Sanctum |
| GET | /api/employees/{id} | Get employee details | Sanctum |
| PUT | /api/employees/{id} | Update employee | Sanctum |
| DELETE | /api/employees/{id} | Soft delete employee | Sanctum |
| POST | /api/employees/{id}/restore | Restore deleted employee | Sanctum |
| DELETE | /api/employees/{id}/force | Force delete employee | Sanctum |
| GET | /api/employees/export | Export employees | Sanctum |
| POST | /api/employees/import | Import employees | Sanctum |
| GET | /api/employees/template | Download import template | Sanctum |
| POST | /api/employees/{id}/documents | Upload employee document | Sanctum |
| GET | /api/employees/{id}/documents | List employee documents | Sanctum |
| DELETE | /api/employees/{id}/documents/{docId} | Delete document | Sanctum |
| GET | /api/employees/{id}/history | Get employee change history | Sanctum |
| GET | /api/employees/{id}/timeline | Get full employee timeline | Sanctum |

### 5.3.5 Database Schema

```sql
CREATE TABLE employees (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    employee_id VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255) NULL,
    nickname VARCHAR(255) NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    personal_email VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    mobile VARCHAR(20) NULL,
    avatar VARCHAR(255) NULL,
    department_id BIGINT UNSIGNED NOT NULL,
    position_id BIGINT UNSIGNED NOT NULL,
    employment_type ENUM('permanent','contract','intern','probation') DEFAULT 'probation',
    employment_status ENUM('active','resigned','terminated','suspended') DEFAULT 'active',
    hire_date DATE NOT NULL,
    probation_end_date DATE NULL,
    contract_end_date DATE NULL,
    termination_date DATE NULL,
    resignation_date DATE NULL,
    salary DECIMAL(15,2) NULL,
    salary_currency VARCHAR(3) DEFAULT 'USD',
    pay_frequency ENUM('weekly','biweekly','monthly') DEFAULT 'monthly',
    bank_name VARCHAR(255) NULL,
    bank_account VARCHAR(50) NULL,
    bank_code VARCHAR(20) NULL,
    tax_id VARCHAR(50) NULL,
    date_of_birth DATE NULL,
    gender ENUM('male','female','other','prefer_not_to_say') NULL,
    marital_status ENUM('single','married','divorced','widowed') NULL,
    nationality VARCHAR(100) NULL,
    address_line1 VARCHAR(255) NULL,
    address_line2 VARCHAR(255) NULL,
    city VARCHAR(100) NULL,
    state VARCHAR(100) NULL,
    postal_code VARCHAR(20) NULL,
    country VARCHAR(100) NULL,
    emergency_contact_name VARCHAR(255) NULL,
    emergency_contact_phone VARCHAR(20) NULL,
    emergency_contact_relation VARCHAR(100) NULL,
    education_level VARCHAR(100) NULL,
    education_institution VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_emp_department (department_id),
    INDEX idx_emp_position (position_id),
    INDEX idx_emp_status (employment_status),
    INDEX idx_emp_hire_date (hire_date),
    INDEX idx_emp_name (first_name, last_name),
    CONSTRAINT fk_emp_department FOREIGN KEY (department_id) REFERENCES departments(id),
    CONSTRAINT fk_emp_position FOREIGN KEY (position_id) REFERENCES positions(id)
);

CREATE TABLE employee_documents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    document_type VARCHAR(50) NOT NULL,
    document_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size INT UNSIGNED,
    mime_type VARCHAR(100),
    is_verified BOOLEAN DEFAULT FALSE,
    verified_by BIGINT UNSIGNED NULL,
    verified_at TIMESTAMP NULL,
    expires_at DATE NULL,
    notes TEXT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_doc_employee (employee_id),
    CONSTRAINT fk_doc_employee FOREIGN KEY (employee_id) REFERENCES employees(id)
);
```

### 5.3.6 Relationships

Employee (N) --- (1) Department
Employee (N) --- (1) Position
Employee (1) --- (N) EmployeeDocument
Employee (1) --- (0..1) User
Employee (1) --- (N) Attendance
Employee (1) --- (N) Leave
Employee (1) --- (N) Payroll
Employee (1) --- (N) PerformanceReview
Employee (1) --- (N) AuditLog (as subject)

### 5.3.7 CRUD Flow

POST /api/employees
  -> Authorize: employee.create
  -> Validate request
  -> Generate employee_id (EMP-YYYY-XXXX)
  -> Create user account (optional, based on setting)
  -> Create employee record
  -> Sync with department headcount
  -> Log audit: employee.created
  -> Dispatch EmployeeCreatedNotification
  -> Return employee resource

PUT /api/employees/{id}
  -> Authorize: employee.update
  -> Validate request
  -> Capture old values for audit
  -> Update employee record
  -> If status changed -> trigger relevant workflows
  -> Log audit: employee.updated (with diff)
  -> Dispatch EmployeeUpdatedNotification
  -> Return employee resource

DELETE /api/employees/{id}
  -> Authorize: employee.delete
  -> Check for active dependencies (leave, payroll)
  -> Soft delete employee
  -> If user account exists -> deactivate user
  -> Log audit: employee.deleted
  -> Return success

### 5.3.8 Search, Filter, Pagination

| Parameter | Type | Description |
|-----------|------|-------------|
| search | string | Search by name, employee_id, email, phone |
| department_id | int | Filter by department |
| position_id | int | Filter by position |
| employment_status | string | active, resigned, terminated, suspended |
| employment_type | string | permanent, contract, intern, probation |
| hire_date_from | date | Filter by hire date range start |
| hire_date_to | date | Filter by hire date range end |
| is_active | boolean | Filter by active status |
| per_page | int | Items per page (default: 15, max: 100) |
| page | int | Page number |
| sort | string | Sort field |
| direction | string | Sort direction |
| with | string | Comma-separated relations |
| trashed | string | none, only, with for soft deletes |

### 5.3.9 Import / Export

**Import Flow:**
1. User downloads CSV template via GET /api/employees/template
2. User fills in employee data following template headers
3. User uploads CSV via POST /api/employees/import
4. System validates each row with error reporting
5. Valid rows are imported; invalid rows are reported with error messages
6. Summary email sent with import results

**Import Validation:**
- Row-level validation with line number reference
- Max 1,000 rows per import
- Duplicate email detection
- Department/Position existence validation

### 5.3.10 Audit Trail

| Event | Description |
|-------|-------------|
| employee.created | New employee record created |
| employee.updated | Employee details changed (field-level diff) |
| employee.deleted | Employee record soft-deleted |
| employee.restored | Employee record restored |
| employee.document.uploaded | Document uploaded |
| employee.document.deleted | Document deleted |
| employee.document.verified | Document verified |

---

## 5.4 Department Module

### 5.4.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| DEPT-01 | HR | Create departments with hierarchy | I can organize the company structure |
| DEPT-02 | HR | Assign a manager to each department | There is clear leadership |
| DEPT-03 | HR | View headcount per department | I can track team sizes |
| DEPT-04 | HR | Set department budget | We can track spending |

### 5.4.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| DEPT-BR01 | Department name must be unique |
| DEPT-BR02 | A department can have one parent (self-referencing hierarchy) |
| DEPT-BR03 | Maximum hierarchy depth: 5 levels |
| DEPT-BR04 | Cannot delete a department that has employees assigned |
| DEPT-BR05 | A manager can manage multiple departments |

### 5.4.3 API Design

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/departments | List departments |
| POST | /api/departments | Create department |
| GET | /api/departments/{id} | Get department details |
| PUT | /api/departments/{id} | Update department |
| DELETE | /api/departments/{id} | Delete department |
| GET | /api/departments/tree | Get department hierarchy tree |

### 5.4.4 Database Schema

```sql
CREATE TABLE departments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL UNIQUE,
    code VARCHAR(20) UNIQUE,
    description TEXT NULL,
    manager_id BIGINT UNSIGNED NULL,
    budget DECIMAL(15,2) NULL,
    budget_currency VARCHAR(3) DEFAULT 'USD',
    cost_center VARCHAR(50) NULL,
    location VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_dept_parent (parent_id),
    INDEX idx_dept_manager (manager_id),
    CONSTRAINT fk_dept_parent FOREIGN KEY (parent_id) REFERENCES departments(id)
);
```

### 5.4.5 Relationships

Department (1) --- (N) Employee
Department (1) --- (0..1) Department (parent)
Department (1) --- (N) Department (children)
Department (1) --- (0..1) Employee (manager)

---

## 5.5 Position Module

### 5.5.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| POS-01 | HR | Create positions with job descriptions | I can define roles clearly |
| POS-02 | HR | Define position requirements and skills | I can match candidates |
| POS-03 | HR | Set salary range per position | I can budget effectively |
| POS-04 | HR | View position occupancy (filled/vacant) | I know open headcount |

### 5.5.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| POS-BR01 | Position name must be unique within a department |
| POS-BR02 | A position can have multiple employees (unless max_headcount is set) |
| POS-BR03 | Salary range (min - max) must be logical |
| POS-BR04 | Cannot delete a position that has employees assigned |

### 5.5.3 API Design

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/positions | List positions |
| POST | /api/positions | Create position |
| GET | /api/positions/{id} | Get position details |
| PUT | /api/positions/{id} | Update position |
| DELETE | /api/positions/{id} | Delete position |

### 5.5.4 Database Schema

```sql
CREATE TABLE positions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    department_id BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    title VARCHAR(255) NOT NULL,
    code VARCHAR(20) UNIQUE,
    description TEXT NULL,
    requirements TEXT NULL,
    responsibilities TEXT NULL,
    min_salary DECIMAL(15,2) NULL,
    max_salary DECIMAL(15,2) NULL,
    salary_currency VARCHAR(3) DEFAULT 'USD',
    employment_type ENUM('full_time','part_time','contract','internship') DEFAULT 'full_time',
    max_headcount INT UNSIGNED NULL,
    current_headcount INT UNSIGNED DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_pos_dept (department_id),
    INDEX idx_pos_title (title),
    CONSTRAINT fk_pos_dept FOREIGN KEY (department_id) REFERENCES departments(id)
);
```

### 5.5.5 Relationships

Position (N) --- (1) Department
Position (1) --- (N) Employee
Position (1) --- (0..1) Position (parent, for reporting structure)
Position (N) --- (N) JobPosting (recruitment)
## 5.6 Attendance Module

### 5.6.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| ATT-01 | Employee | Clock in and out | I can record my work hours |
| ATT-02 | Employee | View my attendance history | I can track my presence |
| ATT-03 | Employee | Submit timesheets for approval | My hours are validated |
| ATT-04 | Manager | View team attendance in real-time | I can see who's working |
| ATT-05 | Manager | Approve/reject timesheets | Team hours are accurate |
| ATT-06 | HR | View attendance reports | I can process payroll |
| ATT-07 | HR | Configure work schedule and holidays | Attendance rules are defined |

### 5.6.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| ATT-BR01 | Employee can clock in only within geofenced area (if enabled) |
| ATT-BR02 | Cannot clock in before scheduled start time - 15 min grace period |
| ATT-BR03 | Late clock-in (after grace period) is flagged as late |
| ATT-BR04 | Early clock-out (before end time - 15 min) flagged as early_departure |
| ATT-BR05 | Overtime requires manager pre-approval (configurable) |
| ATT-BR06 | Max 2 clock-in/clock-out pairs per day (lunch break) |
| ATT-BR07 | Timesheet submission deadline: next business day by 12:00 PM |
| ATT-BR08 | Auto clock-out at 12:00 AM if not clocked out (configurable) |
| ATT-BR09 | Weekly max hours: 48 (configurable by country law) |
| ATT-BR10 | IP restriction can be enforced per company |

### 5.6.3 Validation Rules

| Field | Rule | Error Message |
|-------|------|---------------|
| clock_in | required, date | Clock in time is required. |
| clock_out | required_if:completed, date, after:clock_in | Clock out must be after clock in. |
| latitude | required_if:geolocation, numeric, between:-90,90 | Valid latitude is required. |
| longitude | required_if:geolocation, numeric, between:-180,180 | Valid longitude is required. |
| notes | max:500 | Notes cannot exceed 500 characters. |

### 5.6.4 API Design

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | /api/attendance/clock-in | Clock in |
| POST | /api/attendance/clock-out | Clock out |
| GET | /api/attendance/today | Get today's attendance |
| GET | /api/attendance | List attendance records |
| GET | /api/attendance/{id} | Get attendance detail |
| PUT | /api/attendance/{id} | Update attendance (HR only) |
| GET | /api/attendance/summary | Get attendance summary |
| GET | /api/attendance/report | Generate attendance report |
| POST | /api/attendance/import | Import attendance data |
| GET | /api/attendance/my-schedule | Get my work schedule |
| GET | /api/attendance/holidays | List holidays |

### 5.6.5 Database Schema

```sql
CREATE TABLE attendance_records (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    clock_in DATETIME NOT NULL,
    clock_out DATETIME NULL,
    clock_in_ip VARCHAR(45) NULL,
    clock_out_ip VARCHAR(45) NULL,
    clock_in_latitude DECIMAL(10,7) NULL,
    clock_in_longitude DECIMAL(10,7) NULL,
    clock_out_latitude DECIMAL(10,7) NULL,
    clock_out_longitude DECIMAL(10,7) NULL,
    clock_in_photo VARCHAR(255) NULL,
    clock_out_photo VARCHAR(255) NULL,
    clock_in_notes TEXT NULL,
    clock_out_notes TEXT NULL,
    total_hours DECIMAL(5,2) NULL,
    regular_hours DECIMAL(5,2) NULL,
    overtime_hours DECIMAL(5,2) NULL,
    late_minutes INT DEFAULT 0,
    early_departure_minutes INT DEFAULT 0,
    status ENUM('present','late','absent','half_day','on_leave','holiday','weekend') DEFAULT 'present',
    timesheet_status ENUM('draft','submitted','approved','rejected') DEFAULT 'draft',
    approved_by BIGINT UNSIGNED NULL,
    approved_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    UNIQUE KEY uk_employee_date (employee_id, date),
    INDEX idx_att_date (date),
    INDEX idx_att_employee (employee_id),
    INDEX idx_att_status (status),
    INDEX idx_att_timesheet_status (timesheet_status),
    CONSTRAINT fk_att_employee FOREIGN KEY (employee_id) REFERENCES employees(id)
);

CREATE TABLE work_schedules (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    day_of_week TINYINT NOT NULL COMMENT '0=Sun, 1=Mon, ... 6=Sat',
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    break_start_time TIME NULL,
    break_end_time TIME NULL,
    is_weekend BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE employee_schedules (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    schedule_id BIGINT UNSIGNED NOT NULL,
    effective_from DATE NOT NULL,
    effective_to DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_emp_schedule_employee (employee_id),
    CONSTRAINT fk_emp_schedule_emp FOREIGN KEY (employee_id) REFERENCES employees(id),
    CONSTRAINT fk_emp_schedule_sched FOREIGN KEY (schedule_id) REFERENCES work_schedules(id)
);

CREATE TABLE holidays (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    type ENUM('national','company','regional') DEFAULT 'national',
    is_recurring BOOLEAN DEFAULT FALSE,
    duration ENUM('full_day','half_day') DEFAULT 'full_day',
    year YEAR NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_holiday_date_name (date, name)
);
```

### 5.6.6 Attendance Workflow

Employee clicks "Clock In"
  -> Check: Is employee active?
  -> Check: Is today a holiday/weekend? (optional clock-in allowed)
  -> Check: Geofence validation (if enabled)
  -> Check: Not already clocked in
  -> Create attendance_record with clock_in time
  -> Calculate: late_minutes (if after schedule start + grace)
  -> Return attendance record

Employee clicks "Clock Out"
  -> Check: Is employee clocked in?
  -> Update attendance_record with clock_out time
  -> Calculate: total_hours, regular_hours, overtime_hours, early_departure_minutes
  -> Update status
  -> Return updated record

---

## 5.7 Leave Module

### 5.7.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| LEV-01 | Employee | Request leave with date range and reason | I can take time off |
| LEV-02 | Employee | See my leave balance for all leave types | I know what I'm entitled to |
| LEV-03 | Employee | View my leave history | I can track my leave usage |
| LEV-04 | Employee | Cancel a pending leave request | I can change my plans |
| LEV-05 | Manager | View team leave calendar | I can plan coverage |
| LEV-06 | Manager | Approve or reject leave requests | I can manage team availability |
| LEV-07 | HR | Configure leave types and policies | Rules are correctly applied |
| LEV-08 | HR | View all leave requests across company | I can monitor attendance |
| LEV-09 | Finance | View leave encashment reports | I can process payments |

### 5.7.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| LEV-BR01 | Leave balance is calculated based on employment date and policy |
| LEV-BR02 | Annual leave entitlement is prorated for mid-year hires |
| LEV-BR03 | Leave request must be submitted at least 1 day in advance |
| LEV-BR04 | Consecutive leave with same type can be submitted as one request |
| LEV-BR05 | Maximum consecutive leave days: 30 (configurable) |
| LEV-BR06 | Sick leave > 3 days requires medical certificate |
| LEV-BR07 | Leave cannot span across non-working days (weekends excluded from count) |
| LEV-BR08 | Pending leave can be cancelled by employee |
| LEV-BR09 | Leave approval requires at least one level of manager approval |
| LEV-BR10 | Negative leave balance is not allowed (except sick leave) |
| LEV-BR11 | Leave balance resets annually based on policy calendar |
| LEV-BR12 | Unused leave can be carried forward (max 5 days) |

### 5.7.3 Leave Types (Configurable)

Annual Leave, Sick Leave, Personal Leave, Maternity Leave, Paternity Leave,
Bereavement Leave, Study Leave, Unpaid Leave, Compensatory Off

### 5.7.4 API Design

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/leave-requests | List leave requests |
| POST | /api/leave-requests | Create leave request |
| GET | /api/leave-requests/{id} | Get leave request detail |
| PUT | /api/leave-requests/{id} | Update leave request |
| DELETE | /api/leave-requests/{id} | Cancel leave request |
| POST | /api/leave-requests/{id}/approve | Approve leave request |
| POST | /api/leave-requests/{id}/reject | Reject leave request |
| GET | /api/leave-balances | Get my leave balances |
| GET | /api/leave-balances/{employeeId} | Get employee leave balances |
| GET | /api/leave-types | List leave types |
| POST | /api/leave-types | Create leave type (HR) |
| PUT | /api/leave-types/{id} | Update leave type (HR) |
| GET | /api/leave/calendar | Get leave calendar data |
| GET | /api/leave/report | Generate leave report |

### 5.7.5 Database Schema

```sql
CREATE TABLE leave_types (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(20) UNIQUE NOT NULL,
    description TEXT NULL,
    days_per_year DECIMAL(5,2) NOT NULL,
    is_paid BOOLEAN DEFAULT TRUE,
    requires_approval BOOLEAN DEFAULT TRUE,
    requires_document BOOLEAN DEFAULT FALSE,
    max_consecutive_days INT NULL,
    min_days_before_request INT DEFAULT 1,
    carry_forward_days DECIMAL(5,2) DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    applicable_gender ENUM('all','male','female') DEFAULT 'all',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

CREATE TABLE leave_balances (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    leave_type_id BIGINT UNSIGNED NOT NULL,
    year YEAR NOT NULL,
    total_days DECIMAL(5,2) NOT NULL,
    used_days DECIMAL(5,2) DEFAULT 0,
    pending_days DECIMAL(5,2) DEFAULT 0,
    remaining_days DECIMAL(5,2) GENERATED ALWAYS AS (total_days - used_days - pending_days) STORED,
    carried_forward DECIMAL(5,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_leave_balance (employee_id, leave_type_id, year),
    INDEX idx_lb_employee (employee_id),
    CONSTRAINT fk_lb_employee FOREIGN KEY (employee_id) REFERENCES employees(id),
    CONSTRAINT fk_lb_leave_type FOREIGN KEY (leave_type_id) REFERENCES leave_types(id)
);

CREATE TABLE leave_requests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    leave_type_id BIGINT UNSIGNED NOT NULL,
    uuid CHAR(36) UNIQUE NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_days DECIMAL(5,2) NOT NULL,
    duration ENUM('full_day','half_day_morning','half_day_afternoon') DEFAULT 'full_day',
    reason TEXT NOT NULL,
    document_path VARCHAR(255) NULL,
    notes TEXT NULL,
    status ENUM('pending','approved','rejected','cancelled') DEFAULT 'pending',
    approved_by BIGINT UNSIGNED NULL,
    approved_at TIMESTAMP NULL,
    rejection_reason TEXT NULL,
    current_level INT DEFAULT 1,
    max_level INT DEFAULT 1,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_lr_employee (employee_id),
    INDEX idx_lr_status (status),
    INDEX idx_lr_dates (start_date, end_date),
    INDEX idx_lr_leave_type (leave_type_id),
    CONSTRAINT fk_lr_employee FOREIGN KEY (employee_id) REFERENCES employees(id),
    CONSTRAINT fk_lr_leave_type FOREIGN KEY (leave_type_id) REFERENCES leave_types(id)
);

CREATE TABLE leave_approvals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    leave_request_id BIGINT UNSIGNED NOT NULL,
    approver_id BIGINT UNSIGNED NOT NULL,
    level INT NOT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    action_at TIMESTAMP NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_la_request (leave_request_id),
    INDEX idx_la_approver (approver_id),
    CONSTRAINT fk_la_request FOREIGN KEY (leave_request_id) REFERENCES leave_requests(id),
    CONSTRAINT fk_la_approver FOREIGN KEY (approver_id) REFERENCES employees(id)
);
```

### 5.7.6 Leave Request Workflow

Employee submits leave request
  -> Validate: date range, balance check, policy rules
  -> Create leave_request (status: pending)
  -> Decrement pending_days in leave_balance
  -> Create LeaveApproval record for level 1
  -> Start approval workflow (queue job)
  -> Notify manager(s)

Manager approves
  -> POST /api/leave-requests/{id}/approve
  -> Validate: current user is approver for current level
  -> Update LeaveApproval record
  -> If more levels: create next LeaveApproval, notify next approver
  -> If final level: update status to approved
    -> Decrement used_days, increment pending_days in balance
    -> Notify employee

Manager rejects
  -> POST /api/leave-requests/{id}/reject
  -> Update status to rejected
  -> Restore pending_days in balance
  -> Notify employee
## 5.8 Payroll Module

### 5.8.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| PAY-01 | HR/Finance | Configure payroll components | Payroll structure is defined |
| PAY-02 | HR/Finance | Run payroll for a given period | Salaries are processed |
| PAY-03 | HR/Finance | Preview payroll before finalizing | I can verify calculations |
| PAY-04 | HR/Finance | Process adjustments (bonuses, penalties) | Compensation is accurate |
| PAY-05 | HR/Finance | Generate payroll reports | I can submit to management |
| PAY-06 | Employee | View my payslip | I can see my salary breakdown |
| PAY-07 | Employee | Download payslip PDF | I can save my records |
| PAY-08 | Employee | View payroll history | I can track my earnings |
| PAY-09 | Finance | Export payroll journal entries | I can integrate with accounting |
| PAY-10 | Admin | Set payroll schedule | Payroll runs automatically |

### 5.8.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| PAY-BR01 | Payroll can only be run once per period per employee |
| PAY-BR02 | Payroll must include all active employees as of period end date |
| PAY-BR03 | Payroll cannot be run if previous period is not finalized |
| PAY-BR04 | Attendance data must be approved before payroll processing |
| PAY-BR05 | Leave without pay must be deducted from salary |
| PAY-BR06 | Overtime calculated per configured rates (1.5x regular, 2x holiday) |
| PAY-BR07 | Tax deductions follow configured tax brackets |
| PAY-BR08 | Payroll statuses: draft, processing, completed, cancelled |
| PAY-BR09 | Once completed, adjustments require a separate adjustment run |
| PAY-BR10 | Payslip PDFs are generated after payroll is completed |

### 5.8.3 Payroll Components

| Component | Type | Description |
|-----------|------|-------------|
| Basic Salary | Earnings | Fixed monthly amount from employee record |
| Housing Allowance | Earnings | Fixed or percentage-based |
| Transport Allowance | Earnings | Fixed or percentage-based |
| Meal Allowance | Earnings | Fixed daily/monthly |
| Overtime Pay | Earnings | Calculated from attendance |
| Bonus | Earnings | One-time or periodic |
| Commission | Earnings | Performance-based |
| Tax | Deduction | Calculated based on tax brackets |
| Social Security | Deduction | Statutory deduction |
| Health Insurance | Deduction | Premium deduction |
| Pension | Deduction | Employee contribution |
| Loan Repayment | Deduction | Monthly loan installment |
| Late Deduction | Deduction | Per late attendance policy |
| Absent Deduction | Deduction | Per unapproved absence |

### 5.8.4 API Design

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/payroll/runs | List payroll runs |
| POST | /api/payroll/runs | Create payroll run |
| GET | /api/payroll/runs/{id} | Get payroll run detail |
| POST | /api/payroll/runs/{id}/process | Process payroll calculations |
| POST | /api/payroll/runs/{id}/complete | Finalize payroll (lock) |
| POST | /api/payroll/runs/{id}/cancel | Cancel payroll run |
| GET | /api/payroll/runs/{id}/preview | Preview calculations |
| GET | /api/payroll/runs/{id}/payslips | List payslips in run |
| GET | /api/payroll/payslips | My payslips |
| GET | /api/payroll/payslips/{id} | Get payslip detail |
| GET | /api/payroll/payslips/{id}/download | Download payslip PDF |
| GET | /api/payroll/components | List payroll components |
| POST | /api/payroll/components | Create component |
| PUT | /api/payroll/components/{id} | Update component |
| GET | /api/payroll/report | Generate payroll report |
| POST | /api/payroll/adjustments | Create payroll adjustment |
| EXPORT | /api/payroll/export/journal | Export journal entries |

### 5.8.5 Database Schema

```sql
CREATE TABLE payroll_components (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) UNIQUE NOT NULL,
    type ENUM('earning','deduction') NOT NULL,
    calculation_type ENUM('fixed','percentage','formula') DEFAULT 'fixed',
    amount DECIMAL(15,2) NULL,
    percentage DECIMAL(5,2) NULL,
    formula VARCHAR(255) NULL,
    is_taxable BOOLEAN DEFAULT TRUE,
    is_mandatory BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

CREATE TABLE employee_payroll_components (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    component_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(15,2) NULL,
    percentage DECIMAL(5,2) NULL,
    effective_from DATE NOT NULL,
    effective_to DATE NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_epc_employee (employee_id),
    CONSTRAINT fk_epc_employee FOREIGN KEY (employee_id) REFERENCES employees(id),
    CONSTRAINT fk_epc_component FOREIGN KEY (component_id) REFERENCES payroll_components(id)
);

CREATE TABLE payroll_runs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    period_type ENUM('weekly','biweekly','monthly') NOT NULL,
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    payment_date DATE NOT NULL,
    status ENUM('draft','processing','completed','cancelled') DEFAULT 'draft',
    total_gross DECIMAL(15,2) DEFAULT 0,
    total_deductions DECIMAL(15,2) DEFAULT 0,
    total_net DECIMAL(15,2) DEFAULT 0,
    employee_count INT DEFAULT 0,
    processed_by BIGINT UNSIGNED NULL,
    processed_at TIMESTAMP NULL,
    completed_by BIGINT UNSIGNED NULL,
    completed_at TIMESTAMP NULL,
    notes TEXT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_pr_status (status),
    INDEX idx_pr_period (period_start, period_end)
);

CREATE TABLE payslips (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    payroll_run_id BIGINT UNSIGNED NOT NULL,
    employee_id BIGINT UNSIGNED NOT NULL,
    uuid CHAR(36) UNIQUE NOT NULL,
    basic_salary DECIMAL(15,2) NOT NULL,
    allowances_total DECIMAL(15,2) DEFAULT 0,
    overtime_pay DECIMAL(15,2) DEFAULT 0,
    bonus DECIMAL(15,2) DEFAULT 0,
    gross_salary DECIMAL(15,2) NOT NULL,
    tax DECIMAL(15,2) DEFAULT 0,
    social_security DECIMAL(15,2) DEFAULT 0,
    health_insurance DECIMAL(15,2) DEFAULT 0,
    pension DECIMAL(15,2) DEFAULT 0,
    loan_repayment DECIMAL(15,2) DEFAULT 0,
    other_deductions DECIMAL(15,2) DEFAULT 0,
    total_deductions DECIMAL(15,2) DEFAULT 0,
    net_salary DECIMAL(15,2) NOT NULL,
    working_days INT DEFAULT 0,
    days_present INT DEFAULT 0,
    days_absent INT DEFAULT 0,
    days_on_leave INT DEFAULT 0,
    overtime_hours DECIMAL(5,2) DEFAULT 0,
    late_count INT DEFAULT 0,
    status ENUM('draft','generated','paid') DEFAULT 'draft',
    is_printed BOOLEAN DEFAULT FALSE,
    pdf_path VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ps_run (payroll_run_id),
    INDEX idx_ps_employee (employee_id),
    INDEX idx_ps_status (status),
    CONSTRAINT fk_ps_run FOREIGN KEY (payroll_run_id) REFERENCES payroll_runs(id),
    CONSTRAINT fk_ps_employee FOREIGN KEY (employee_id) REFERENCES employees(id)
);

CREATE TABLE payslip_details (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    payslip_id BIGINT UNSIGNED NOT NULL,
    component_id BIGINT UNSIGNED NOT NULL,
    type ENUM('earning','deduction') NOT NULL,
    label VARCHAR(255) NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_pd_payslip (payslip_id),
    CONSTRAINT fk_pd_payslip FOREIGN KEY (payslip_id) REFERENCES payslips(id),
    CONSTRAINT fk_pd_component FOREIGN KEY (component_id) REFERENCES payroll_components(id)
);

CREATE TABLE payroll_adjustments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    payroll_run_id BIGINT UNSIGNED NULL,
    type ENUM('bonus','penalty','correction','others') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    is_addition BOOLEAN DEFAULT TRUE,
    reason TEXT NOT NULL,
    approved_by BIGINT UNSIGNED NULL,
    approved_at TIMESTAMP NULL,
    status ENUM('pending','approved','applied') DEFAULT 'pending',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_pa_employee (employee_id),
    INDEX idx_pa_run (payroll_run_id),
    CONSTRAINT fk_pa_employee FOREIGN KEY (employee_id) REFERENCES employees(id)
);
```

### 5.8.6 Payroll Processing Flow

1. Create Payroll Run (POST /api/payroll/runs)
   -> Set period, payment date, status = draft

2. Preview (GET /api/payroll/runs/{id}/preview)
   -> For each active employee in period:
      -> Get basic salary
      -> Get allowances (fixed + percentage)
      -> Get attendance data (days present, absent, leave, OT)
      -> Calculate overtime pay
      -> Calculate late/absent deductions
      -> Calculate gross salary
      -> Calculate tax (per bracket)
      -> Calculate statutory deductions
      -> Calculate net salary
   -> Return summary (not saved yet)

3. Process (POST /api/payroll/runs/{id}/process)
   -> Status -> processing
   -> Dispatch ProcessPayrollJob (queued for large batches)
   -> Job iterates employees:
      -> Calculate all earnings and deductions
      -> Create payslip with payslip_details
      -> Calculate run totals
   -> Status -> draft (ready for review)
   -> Notify HR that payroll is ready for review

4. Complete (POST /api/payroll/runs/{id}/complete)
   -> Validate all payslips are calculated
   -> Status -> completed
   -> Update payslip status -> generated
   -> Generate payslip PDFs (queued job)
   -> Lock payroll run (no further edits)
   -> Log audit
   -> Notify employees that payslips are available

### 5.8.7 Audit Trail

| Event | Description |
|-------|-------------|
| payroll.run.created | Payroll run created |
| payroll.run.processed | Payroll processed |
| payroll.run.completed | Payroll finalized |
| payroll.run.cancelled | Payroll cancelled |
| payroll.adjustment.created | Payroll adjustment created |
| payroll.adjustment.approved | Adjustment approved |
| payslip.generated | Payslip generated |

---

## 5.9 Recruitment Module

### 5.9.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| REC-01 | HR | Create job postings | We can advertise vacancies |
| REC-02 | HR | Manage candidate applications | I can track applicants |
| REC-03 | HR | Move candidates through pipeline stages | I can manage the hiring process |
| REC-04 | Hiring Manager | Review candidate profiles | I can evaluate applicants |
| REC-05 | Hiring Manager | Schedule interviews | I can meet candidates |
| REC-06 | HR | Send offer letters to selected candidates | We can close hires |
| REC-07 | Admin | Configure recruitment stages | The process matches our workflow |

### 5.9.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| REC-BR01 | Job posting must have at least one hiring manager |
| REC-BR02 | A candidate cannot apply to the same job twice |
| REC-BR03 | Pipeline stages are configurable per job posting |
| REC-BR04 | Offer letter generation uses configurable templates |
| REC-BR05 | When a candidate is hired, an employee record can be auto-created |
| REC-BR06 | Job posting expiry can be set; closed jobs are not visible |

### 5.9.3 API Design

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/recruitment/jobs | List job postings |
| POST | /api/recruitment/jobs | Create job posting |
| PUT | /api/recruitment/jobs/{id} | Update job posting |
| GET | /api/recruitment/jobs/{id} | Get job posting detail |
| DELETE | /api/recruitment/jobs/{id} | Close/delete job posting |
| GET | /api/recruitment/candidates | List candidates |
| POST | /api/recruitment/candidates | Add candidate |
| GET | /api/recruitment/candidates/{id} | Get candidate detail |
| PUT | /api/recruitment/candidates/{id} | Update candidate |
| POST | /api/recruitment/candidates/{id}/stage | Move candidate to stage |
| POST | /api/recruitment/candidates/{id}/offer | Send offer letter |
| GET | /api/recruitment/pipeline | Get pipeline data |

### 5.9.4 Database Schema

```sql
CREATE TABLE job_postings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    position_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description LONGTEXT NOT NULL,
    requirements LONGTEXT NULL,
    responsibilities LONGTEXT NULL,
    location VARCHAR(255) NULL,
    employment_type ENUM('full_time','part_time','contract','internship') DEFAULT 'full_time',
    min_salary DECIMAL(15,2) NULL,
    max_salary DECIMAL(15,2) NULL,
    vacancies INT DEFAULT 1,
    status ENUM('draft','published','closed','cancelled') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_jp_status (status),
    INDEX idx_jp_position (position_id),
    CONSTRAINT fk_jp_position FOREIGN KEY (position_id) REFERENCES positions(id)
);

CREATE TABLE hiring_managers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_posting_id BIGINT UNSIGNED NOT NULL,
    employee_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_hm_job_employee (job_posting_id, employee_id),
    CONSTRAINT fk_hm_job FOREIGN KEY (job_posting_id) REFERENCES job_postings(id),
    CONSTRAINT fk_hm_employee FOREIGN KEY (employee_id) REFERENCES employees(id)
);

CREATE TABLE recruitment_stages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(50) UNIQUE NOT NULL,
    description TEXT NULL,
    order_column INT NOT NULL,
    color VARCHAR(20) NULL,
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE candidates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_posting_id BIGINT UNSIGNED NOT NULL,
    current_stage_id BIGINT UNSIGNED NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    resume_path VARCHAR(255) NULL,
    cover_letter TEXT NULL,
    source VARCHAR(100) NULL,
    current_company VARCHAR(255) NULL,
    current_position VARCHAR(255) NULL,
    years_of_experience INT NULL,
    education_level VARCHAR(100) NULL,
    expected_salary DECIMAL(15,2) NULL,
    notes TEXT NULL,
    rating INT NULL COMMENT '1-5',
    status ENUM('active','hired','rejected','withdrawn') DEFAULT 'active',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    hired_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_cand_job (job_posting_id),
    INDEX idx_cand_stage (current_stage_id),
    INDEX idx_cand_email (email),
    CONSTRAINT fk_cand_job FOREIGN KEY (job_posting_id) REFERENCES job_postings(id),
    CONSTRAINT fk_cand_stage FOREIGN KEY (current_stage_id) REFERENCES recruitment_stages(id)
);

CREATE TABLE candidate_stage_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    candidate_id BIGINT UNSIGNED NOT NULL,
    from_stage_id BIGINT UNSIGNED NULL,
    to_stage_id BIGINT UNSIGNED NOT NULL,
    notes TEXT NULL,
    moved_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_csl_candidate FOREIGN KEY (candidate_id) REFERENCES candidates(id)
);

CREATE TABLE offer_letters (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    candidate_id BIGINT UNSIGNED NOT NULL,
    job_posting_id BIGINT UNSIGNED NOT NULL,
    offered_salary DECIMAL(15,2) NOT NULL,
    offered_position VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    status ENUM('draft','sent','accepted','rejected','expired') DEFAULT 'draft',
    sent_at TIMESTAMP NULL,
    responded_at TIMESTAMP NULL,
    expires_at TIMESTAMP NOT NULL,
    document_path VARCHAR(255) NULL,
    notes TEXT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ol_candidate (candidate_id),
    CONSTRAINT fk_ol_candidate FOREIGN KEY (candidate_id) REFERENCES candidates(id)
);
```

### 5.9.5 Recruitment Pipeline

```
Job Created (draft) -> Published -> Candidates Apply
Application Review -> Screening -> Phone Interview
Technical Test -> Panel Interview -> Final Interview
Reference Check -> Offer -> Hired
```

---

## 5.10 Performance Review Module

### 5.10.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| PR-01 | HR | Create review cycles | Reviews happen on schedule |
| PR-02 | HR | Assign reviewers (self, manager, peers) | 360-degree feedback is collected |
| PR-03 | Employee | Submit self-assessment | I can reflect on my performance |
| PR-04 | Manager | Review and rate my direct reports | I can give feedback |
| PR-05 | Manager | Set goals and KPIs for team members | Expectations are clear |
| PR-06 | HR | View review results and trends | I can identify development needs |
| PR-07 | Employee | View my review results | I know my performance rating |

### 5.10.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| PR-BR01 | Review cycles are time-bound with start and end dates |
| PR-BR02 | An employee can have only one active review cycle |
| PR-BR03 | Self-review must be submitted before manager review |
| PR-BR04 | Ratings are on a 1-5 scale with defined criteria |
| PR-BR05 | Review can override previous rating |
| PR-BR06 | Employee can view final review but not interim peer reviews |
| PR-BR07 | Reviews are locked after final submission |

### 5.10.3 Database Schema

```sql
CREATE TABLE review_cycles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    type ENUM('annual','semi_annual','quarterly','monthly') NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    self_review_deadline DATE NOT NULL,
    manager_review_deadline DATE NOT NULL,
    status ENUM('draft','active','closed') DEFAULT 'draft',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE performance_reviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    review_cycle_id BIGINT UNSIGNED NOT NULL,
    employee_id BIGINT UNSIGNED NOT NULL,
    reviewer_id BIGINT UNSIGNED NOT NULL,
    type ENUM('self','manager','peer','subordinate') NOT NULL,
    rating DECIMAL(3,1) NULL,
    overall_comment TEXT NULL,
    status ENUM('pending','in_progress','submitted','acknowledged') DEFAULT 'pending',
    submitted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_pr_cycle (review_cycle_id),
    INDEX idx_pr_employee (employee_id),
    INDEX idx_pr_reviewer (reviewer_id),
    CONSTRAINT fk_pr_cycle FOREIGN KEY (review_cycle_id) REFERENCES review_cycles(id),
    CONSTRAINT fk_pr_employee FOREIGN KEY (employee_id) REFERENCES employees(id),
    CONSTRAINT fk_pr_reviewer FOREIGN KEY (reviewer_id) REFERENCES employees(id)
);

CREATE TABLE review_sections (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    review_id BIGINT UNSIGNED NOT NULL,
    criteria VARCHAR(255) NOT NULL,
    rating DECIMAL(3,1) NOT NULL,
    comment TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_rs_review FOREIGN KEY (review_id) REFERENCES performance_reviews(id)
);

CREATE TABLE goals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    review_cycle_id BIGINT UNSIGNED NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    kpi VARCHAR(255) NULL,
    target_value DECIMAL(10,2) NULL,
    current_value DECIMAL(10,2) NULL,
    weight DECIMAL(5,2) DEFAULT 100,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('not_started','in_progress','completed','cancelled') DEFAULT 'not_started',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_goals_employee (employee_id),
    CONSTRAINT fk_goals_employee FOREIGN KEY (employee_id) REFERENCES employees(id)
);
```

---

## 5.11 Announcement Module

### 5.11.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| ANC-01 | HR/Admin | Create announcements | I can communicate with the company |
| ANC-02 | HR/Admin | Target announcements to specific departments | Relevant info reaches right people |
| ANC-03 | HR/Admin | Schedule announcements for future publishing | Timing is controlled |
| ANC-04 | Employee | View recent announcements | I stay informed |
| ANC-05 | Employee | Mark announcements as read | I can track what I've seen |

### 5.11.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| ANC-BR01 | Announcements can be pinned to top (max 3) |
| ANC-BR02 | Scheduled announcements not visible until publish time |
| ANC-BR03 | Expired announcements are auto-archived after configurable days |
| ANC-BR04 | Announcements can target: all, department, position, or specific employees |

### 5.11.3 Database Schema

```sql
CREATE TABLE announcements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT NOT NULL,
    excerpt VARCHAR(500) NULL,
    type ENUM('general','urgent','event','policy','birthday') DEFAULT 'general',
    priority ENUM('low','normal','high','urgent') DEFAULT 'normal',
    is_pinned BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    status ENUM('draft','scheduled','published','archived') DEFAULT 'draft',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_ann_status (status),
    INDEX idx_ann_published (published_at)
);

CREATE TABLE announcement_audiences (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    announcement_id BIGINT UNSIGNED NOT NULL,
    audience_type ENUM('all','department','position','employee') NOT NULL,
    audience_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_aa_announcement FOREIGN KEY (announcement_id) REFERENCES announcements(id)
);

CREATE TABLE announcement_reads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    announcement_id BIGINT UNSIGNED NOT NULL,
    employee_id BIGINT UNSIGNED NOT NULL,
    read_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_ar_announcement_employee (announcement_id, employee_id),
    CONSTRAINT fk_ar_announcement FOREIGN KEY (announcement_id) REFERENCES announcements(id),
    CONSTRAINT fk_ar_employee FOREIGN KEY (employee_id) REFERENCES employees(id)
);
```

---

## 5.12 Notification Module

### 5.12.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| NOT-01 | User | Receive notifications for events | I stay informed |
| NOT-02 | User | Choose notification preferences (in-app, email) | I control my experience |
| NOT-03 | User | Mark notifications as read | I can manage my queue |
| NOT-04 | User | View notification history | I can review past notifications |
| NOT-05 | Admin | Configure notification templates | Brand consistency is maintained |

### 5.12.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| NOT-BR01 | Notifications are stored for 90 days (configurable) |
| NOT-BR02 | Email digests can be sent daily/weekly as alternative to real-time |
| NOT-BR03 | Urgent notifications (leave approval, payroll) always send email |
| NOT-BR04 | In-app notifications show unread count badge |

### 5.12.3 Database Schema

```sql
CREATE TABLE notifications (
    id CHAR(36) PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT UNSIGNED NOT NULL,
    data LONGTEXT NOT NULL,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_notifications_notifiable (notifiable_type, notifiable_id),
    INDEX idx_notifications_read (read_at)
);

CREATE TABLE notification_preferences (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    notification_type VARCHAR(255) NOT NULL,
    channel ENUM('in_app','email','both','none') DEFAULT 'both',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_np_user_type (user_id, notification_type),
    CONSTRAINT fk_np_user FOREIGN KEY (user_id) REFERENCES users(id)
);
```

---

## 5.13 Settings Module

### 5.13.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| SET-01 | Admin | Configure company profile | System reflects our brand |
| SET-02 | Admin | Manage roles and permissions | Access is controlled |
| SET-03 | Admin | Create and assign roles to users | Authorization is managed |
| SET-04 | Admin | Configure system-wide settings | Behavior is customized |
| SET-05 | Admin | Set leave, attendance, and payroll policies | Rules are enforced globally |

### 5.13.2 Database Schema

```sql
CREATE TABLE company_profiles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    legal_name VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    address TEXT NULL,
    city VARCHAR(100) NULL,
    state VARCHAR(100) NULL,
    country VARCHAR(100) NULL,
    postal_code VARCHAR(20) NULL,
    logo_path VARCHAR(255) NULL,
    tax_id VARCHAR(50) NULL,
    registration_number VARCHAR(100) NULL,
    website VARCHAR(255) NULL,
    timezone VARCHAR(50) DEFAULT 'UTC',
    date_format VARCHAR(20) DEFAULT 'Y-m-d',
    time_format VARCHAR(20) DEFAULT 'H:i',
    fiscal_year_start VARCHAR(5) DEFAULT '01-01',
    currency VARCHAR(3) DEFAULT 'USD',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(50) DEFAULT 'web',
    display_name VARCHAR(255) NULL,
    description TEXT NULL,
    is_system BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_role_name_guard (name, guard_name)
);

CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(50) DEFAULT 'web',
    display_name VARCHAR(255) NULL,
    description TEXT NULL,
    module VARCHAR(100) NULL,
    group_name VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_perm_name_guard (name, guard_name)
);

CREATE TABLE model_has_roles (
    role_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (role_id, model_id, model_type),
    CONSTRAINT fk_mhr_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE model_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (permission_id, model_id, model_type),
    CONSTRAINT fk_mhp_permission FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

CREATE TABLE role_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    CONSTRAINT fk_rhp_permission FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    CONSTRAINT fk_rhp_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE system_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    key VARCHAR(255) UNIQUE NOT NULL,
    value LONGTEXT NULL,
    type ENUM('string','boolean','integer','json','array') DEFAULT 'string',
    group_name VARCHAR(100) DEFAULT 'general',
    is_encrypted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
## 5.14 Audit Log Module

### 5.14.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| AUD-01 | Admin | View all system activity | I can monitor system usage |
| AUD-02 | Admin | Filter audit logs by user, action, module | I can investigate specific events |
| AUD-03 | Admin | Export audit logs | I can provide evidence for audits |
| AUD-04 | Admin | See before/after values for changes | I know exactly what changed |
| AUD-05 | Compliance | Retain audit logs for specified period | Regulatory requirements are met |

### 5.14.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| AUD-BR01 | All create, update, delete operations are logged |
| AUD-BR02 | Read operations are not logged (except for sensitive data) |
| AUD-BR03 | Audit logs are immutable (cannot be deleted or modified) |
| AUD-BR04 | Audit logs are retained for 7 years (configurable) |
| AUD-BR05 | Old logs are auto-archived to cold storage |
| AUD-BR06 | Audit logs include: who, what, when, where, and previous values |

### 5.14.3 Database Schema

```sql
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    employee_id BIGINT UNSIGNED NULL,
    user_name VARCHAR(255) NULL,
    user_email VARCHAR(255) NULL,
    event VARCHAR(100) NOT NULL COMMENT 'e.g., employee.created, leave.approved',
    module VARCHAR(100) NOT NULL,
    action VARCHAR(50) NOT NULL COMMENT 'create, update, delete, login, etc.',
    subject_type VARCHAR(255) NULL,
    subject_id BIGINT UNSIGNED NULL,
    subject_description VARCHAR(255) NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    changes JSON NULL COMMENT 'Structured diff of changes',
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    request_id VARCHAR(100) NULL,
    url VARCHAR(500) NULL,
    method VARCHAR(10) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_al_event (event),
    INDEX idx_al_module (module),
    INDEX idx_al_subject (subject_type, subject_id),
    INDEX idx_al_user (user_id),
    INDEX idx_al_created (created_at)
) PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027),
    PARTITION p2027 VALUES LESS THAN (2028),
    PARTITION p_future VALUES LESS THAN MAXVALUE
);
```

### 5.14.4 Complete Audit Event List

| Module | Events |
|--------|--------|
| Authentication | user.login, user.logout, user.login.failed, user.password.changed, user.2fa.enabled, user.2fa.disabled |
| Employee | employee.created, employee.updated, employee.deleted, employee.restored, employee.document.uploaded, employee.document.deleted |
| Department | department.created, department.updated, department.deleted |
| Position | position.created, position.updated, position.deleted |
| Attendance | attendance.clock_in, attendance.clock_out, attendance.updated, attendance.approved, attendance.rejected |
| Leave | leave.requested, leave.approved, leave.rejected, leave.cancelled, leave.balance.adjusted |
| Payroll | payroll.run.created, payroll.run.processed, payroll.run.completed, payroll.run.cancelled, payroll.adjustment.created, payroll.adjustment.approved |
| Recruitment | job.created, job.updated, job.closed, candidate.moved, offer.sent |
| Performance | cycle.created, cycle.launched, review.submitted |
| Settings | role.created, role.updated, role.deleted, permission.assigned, setting.updated |

### 5.14.5 API Design

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/audit-logs | List audit logs |
| GET | /api/audit-logs/{id} | Get audit log detail |
| GET | /api/audit-logs/export | Export audit logs |

---

## 5.15 Report Module

### 5.15.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| RPT-01 | HR/Manager | Generate employee list reports | I can export workforce data |
| RPT-02 | HR | Generate attendance reports | I can analyze attendance patterns |
| RPT-03 | HR/Finance | Generate payroll summary reports | I can review compensation |
| RPT-04 | HR | Generate leave utilization reports | I can see leave trends |
| RPT-05 | Manager | Generate department budget reports | I can track spending |
| RPT-06 | Admin | Schedule recurring reports | Reports are sent automatically |
| RPT-07 | Admin | Export reports in multiple formats | I can share with stakeholders |

### 5.15.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| RPT-BR01 | Report data is subject to role-based access |
| RPT-BR02 | Reports can be scheduled daily, weekly, monthly, quarterly, annually |
| RPT-BR03 | Report recipients are configurable via email distribution list |
| RPT-BR04 | Generated reports are stored for 30 days (configurable) |
| RPT-BR05 | Large reports (>10k rows) are generated asynchronously via queue |

### 5.15.3 Database Schema

```sql
CREATE TABLE report_definitions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) UNIQUE NOT NULL,
    description TEXT NULL,
    module VARCHAR(100) NOT NULL,
    sql_query TEXT NULL,
    parameters JSON NULL,
    columns JSON NOT NULL,
    is_system BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE generated_reports (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    report_definition_id BIGINT UNSIGNED NOT NULL,
    parameters JSON NULL,
    format ENUM('csv','xlsx','pdf') NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size INT UNSIGNED NULL,
    row_count INT UNSIGNED NULL,
    status ENUM('pending','generating','completed','failed') DEFAULT 'pending',
    error_message TEXT NULL,
    generated_by BIGINT UNSIGNED NOT NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_gr_status (status),
    INDEX idx_gr_creator (generated_by),
    CONSTRAINT fk_gr_definition FOREIGN KEY (report_definition_id) REFERENCES report_definitions(id)
);

CREATE TABLE report_schedules (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    report_definition_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    frequency ENUM('daily','weekly','biweekly','monthly','quarterly','annually') NOT NULL,
    day_of_week TINYINT NULL,
    day_of_month TINYINT NULL,
    time TIME NOT NULL,
    format ENUM('csv','xlsx','pdf') DEFAULT 'xlsx',
    recipients JSON NOT NULL COMMENT 'Array of email addresses',
    parameters JSON NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_run_at TIMESTAMP NULL,
    next_run_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_rs_next_run (next_run_at),
    CONSTRAINT fk_rs_definition FOREIGN KEY (report_definition_id) REFERENCES report_definitions(id)
);
```

### 5.15.4 API Design

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/reports | List available report definitions |
| POST | /api/reports/generate | Generate a report |
| GET | /api/reports/generated | List generated reports |
| GET | /api/reports/generated/{id} | Download generated report |
| DELETE | /api/reports/generated/{id} | Delete generated report |
| GET | /api/reports/schedules | List report schedules |
| POST | /api/reports/schedules | Create report schedule |
| PUT | /api/reports/schedules/{id} | Update report schedule |
| DELETE | /api/reports/schedules/{id} | Delete report schedule |

---

## 5.16 Analytics Module

### 5.16.1 User Stories

| ID | As a... | I want to... | So that... |
|----|---------|--------------|------------|
| ANL-01 | HR/Admin | View workforce analytics dashboard | I can see headcount trends |
| ANL-02 | HR | View turnover rate analytics | I can measure retention |
| ANL-03 | HR | View leave usage patterns | I can spot trends |
| ANL-04 | HR/Manager | View department-wise analytics | I can compare teams |
| ANL-05 | HR | View recruitment funnel analytics | I can optimize hiring |
| ANL-06 | Admin | View system usage analytics | I can measure adoption |

### 5.16.2 Business Rules

| Rule ID | Description |
|---------|-------------|
| ANL-BR01 | Analytics data is cached and refreshed periodically |
| ANL-BR02 | Historical data is retained for 5 years |
| ANL-BR03 | Analytics are role-scoped (manager sees only their team) |
| ANL-BR04 | Data aggregation happens via scheduled jobs |

### 5.16.3 Database Schema

```sql
CREATE TABLE analytics_cache (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    key VARCHAR(255) UNIQUE NOT NULL,
    data JSON NOT NULL,
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    INDEX idx_ac_expires (expires_at)
);

CREATE TABLE analytics_headcount_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    department_id BIGINT UNSIGNED NULL,
    total_employees INT NOT NULL,
    active_employees INT NOT NULL,
    new_hires INT DEFAULT 0,
    terminations INT DEFAULT 0,
    turnover_rate DECIMAL(5,2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_ahh_date_dept (date, department_id)
);

CREATE TABLE analytics_leave_summary (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    month DATE NOT NULL,
    leave_type_id BIGINT UNSIGNED NOT NULL,
    department_id BIGINT UNSIGNED NULL,
    total_requests INT DEFAULT 0,
    approved_days DECIMAL(10,2) DEFAULT 0,
    rejected_requests INT DEFAULT 0,
    employees_on_leave INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_als_month_type_dept (month, leave_type_id, department_id)
);
```

### 5.16.4 API Design

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/analytics/headcount | Headcount analytics |
| GET | /api/analytics/turnover | Turnover rate analytics |
| GET | /api/analytics/attendance | Attendance pattern analytics |
| GET | /api/analytics/leave | Leave usage analytics |
| GET | /api/analytics/payroll | Payroll cost analytics |
| GET | /api/analytics/recruitment | Recruitment funnel analytics |
| GET | /api/analytics/performance | Performance distribution analytics |
| GET | /api/analytics/overview | Executive overview dashboard |

---

# 6. Non-Functional Requirements

## 6.1 Performance Requirements

| ID | Requirement | Target |
|----|-------------|--------|
| PERF-01 | API Response Time (P95) | < 200ms |
| PERF-02 | API Response Time (P99) | < 500ms |
| PERF-03 | Page Load Time (P95) | < 2 seconds |
| PERF-04 | Database Query Time (P95) | < 50ms |
| PERF-05 | Report Generation (10k rows) | < 10 seconds |
| PERF-06 | Payroll Processing (1k employees) | < 30 seconds |
| PERF-07 | Search Response Time | < 300ms |
| PERF-08 | Concurrent Users | 10,000 |
| PERF-09 | Cache Hit Ratio | > 85% |

## 6.2 Scalability Requirements

| ID | Requirement |
|----|-------------|
| SCALE-01 | Horizontal scaling via load balancer |
| SCALE-02 | Database read replicas for reporting queries |
| SCALE-03 | Multiple queue workers for async processing |
| SCALE-04 | Stateless application instances (session in Redis) |
| SCALE-05 | S3-compatible object storage for documents |
| SCALE-06 | All query paths must be indexed |
| SCALE-07 | Connection pooling with persistent connections |
| SCALE-08 | API rate limiting per user (60 req/min, burst 100) |

## 6.3 Security Requirements

| ID | Requirement |
|----|-------------|
| SEC-01 | Laravel Sanctum token-based auth with configurable TTL |
| SEC-02 | RBAC with granular permissions |
| SEC-03 | Password policy: min 12 chars, complexity, expiry 90 days |
| SEC-04 | TOTP-based two-factor authentication |
| SEC-05 | Configurable session timeout, concurrent session limit |
| SEC-06 | 5 failed attempts -> 15 min lockout |
| SEC-07 | Eloquent ORM with parameterized queries |
| SEC-08 | Blade auto-escaping, Content-Security-Policy headers |
| SEC-09 | Sanctum CSRF protection for SPA |
| SEC-10 | Sensitive data encrypted at rest (AES-256) |
| SEC-11 | All traffic over TLS 1.3 |
| SEC-12 | Immutable audit trail for all critical actions |
| SEC-13 | Field-level permissions for sensitive fields |
| SEC-14 | GDPR compliance: data export, right to deletion |
| SEC-15 | API keys for external integrations with scoped permissions |

## 6.4 Testing Requirements

| ID | Requirement | Target |
|----|-------------|--------|
| TEST-01 | Unit Tests | > 85% code coverage |
| TEST-02 | Feature Tests | All CRUD operations tested |
| TEST-03 | API Tests | All endpoints tested |
| TEST-04 | Integration Tests | Service layer + external services |
| TEST-05 | Load Tests | K6 scripts for critical paths |
| TEST-06 | Security Tests | OWASP Top 10 vulnerability scan |
| TEST-07 | UI Tests | Critical user flows |
| TEST-08 | Accessibility Tests | WCAG 2.1 AA compliance |

## 6.5 Accessibility Requirements

| ID | Requirement |
|----|-------------|
| A11Y-01 | Keyboard navigation for all functionality |
| A11Y-02 | Screen reader support with ARIA labels |
| A11Y-03 | Color contrast minimum 4.5:1 for normal text |
| A11Y-04 | Visible focus indicators on all interactive elements |
| A11Y-05 | Page works at 200% zoom |
| A11Y-06 | Clear error messages with suggestions |
| A11Y-07 | All form fields have associated labels |

## 6.6 Logging & Monitoring

| ID | Requirement |
|----|-------------|
| LOG-01 | Laravel daily logs with configurable levels |
| LOG-02 | Structured JSON logging for aggregation |
| LOG-03 | Centralized log shipping (ELK/Loki) |
| LOG-04 | Immutable database audit trail |
| LOG-05 | Full HTTP request/response logging for debugging |
| LOG-06 | Job execution logs with success/failure tracking |
| LOG-07 | Slow query log (>100ms) |

## 6.7 Monitoring Requirements

| ID | Requirement | Tool |
|----|-------------|------|
| MON-01 | Application Performance | Laravel Telescope |
| MON-02 | Server Monitoring | Grafana + Prometheus |
| MON-03 | Database Monitoring | MySQL metrics |
| MON-04 | Queue Monitoring | Laravel Horizon |
| MON-05 | Cache Monitoring | Redis metrics |
| MON-06 | Uptime Monitoring | 99.9% SLA |
| MON-07 | Error Tracking | Sentry / Flare |
| MON-08 | Alerting | Slack/PagerDuty alerts |

## 6.8 Deployment Requirements

| ID | Requirement |
|----|-------------|
| DEP-01 | CI/CD Pipeline via GitHub Actions |
| DEP-02 | Docker containers for consistent environments |
| DEP-03 | Kubernetes for container orchestration |
| DEP-04 | Dev, Staging, Production environment parity |
| DEP-05 | Zero-downtime deployments with health checks |
| DEP-06 | Automated database migrations with rollback |
| DEP-07 | Configuration via .env + secrets manager |
| DEP-08 | Daily database backups, 30-day retention |
| DEP-09 | RTO: 4 hours, RPO: 1 hour |
# 7. Entity Relationship Diagram

## 7.1 Core Entity Map

Users (1) -----> (0..1) Employees
Departments (1) -----> (N) Employees
Positions (1) -----> (N) Employees
Departments (1) -----> (N) Departments (self-referencing hierarchy)

Employees (1) -----> (N) AttendanceRecords
Employees (1) -----> (N) LeaveRequests
Employees (1) -----> (N) Payslips
Employees (1) -----> (N) PerformanceReviews
Employees (1) -----> (N) EmployeeDocuments
Employees (1) -----> (N) Goals

LeaveTypes (1) -----> (N) LeaveRequests
LeaveTypes (1) -----> (N) LeaveBalances
LeaveRequests (1) -----> (N) LeaveApprovals

PayrollRuns (1) -----> (N) Payslips
Payslips (1) -----> (N) PayslipDetails
PayrollComponents (1) -----> (N) PayslipDetails

JobPostings (1) -----> (N) Candidates
RecruitmentStages (1) -----> (N) Candidates
Candidates (1) -----> (N) CandidateStageLogs
Candidates (1) -----> (0..1) OfferLetters
JobPostings (N) -----> (N) HiringManagers

ReviewCycles (1) -----> (N) PerformanceReviews
PerformanceReviews (1) -----> (N) ReviewSections

Announcements (1) -----> (N) AnnouncementAudiences
Announcements (1) -----> (N) AnnouncementReads

Roles (N) -----> (N) Permissions (via role_has_permissions)
Users (N) -----> (N) Roles (via model_has_roles)

---

# 8. Database Schema

## 8.1 Complete Table Inventory

| # | Table | Module | Type | Rows Est. |
|---|-------|--------|------|-----------|
| 1 | users | Auth | Core | 10k |
| 2 | password_reset_tokens | Auth | Temp | - |
| 3 | personal_access_tokens | Auth | Sanctum | 50k |
| 4 | sessions | Auth | Cache | 10k |
| 5 | employees | Employee | Core | 10k |
| 6 | employee_documents | Employee | Child | 30k |
| 7 | departments | Department | Core | 100 |
| 8 | positions | Position | Core | 500 |
| 9 | attendance_records | Attendance | Core | 3.6M/yr |
| 10 | work_schedules | Attendance | Reference | 20 |
| 11 | employee_schedules | Attendance | Child | 10k |
| 12 | holidays | Attendance | Reference | 50 |
| 13 | leave_types | Leave | Reference | 10 |
| 14 | leave_balances | Leave | Child | 100k |
| 15 | leave_requests | Leave | Core | 50k/yr |
| 16 | leave_approvals | Leave | Child | 150k/yr |
| 17 | payroll_components | Payroll | Reference | 20 |
| 18 | employee_payroll_components | Payroll | Child | 50k |
| 19 | payroll_runs | Payroll | Core | 120/yr |
| 20 | payslips | Payroll | Core | 120k/yr |
| 21 | payslip_details | Payroll | Child | 2.4M/yr |
| 22 | payroll_adjustments | Payroll | Child | 5k/yr |
| 23 | job_postings | Recruitment | Core | 500/yr |
| 24 | hiring_managers | Recruitment | Child | 1k |
| 25 | recruitment_stages | Recruitment | Reference | 10 |
| 26 | candidates | Recruitment | Core | 5k/yr |
| 27 | candidate_stage_logs | Recruitment | Child | 25k/yr |
| 28 | offer_letters | Recruitment | Child | 500/yr |
| 29 | review_cycles | Performance | Core | 10 |
| 30 | performance_reviews | Performance | Core | 50k/yr |
| 31 | review_sections | Performance | Child | 250k/yr |
| 32 | goals | Performance | Core | 20k |
| 33 | announcements | Announcement | Core | 500/yr |
| 34 | announcement_audiences | Announcement | Child | 1k |
| 35 | announcement_reads | Announcement | Child | 500k/yr |
| 36 | notifications | Notification | Core | 500k/yr |
| 37 | notification_preferences | Notification | Child | 10k |
| 38 | company_profiles | Settings | Core | 1 |
| 39 | roles | Settings | Reference | 20 |
| 40 | permissions | Settings | Reference | 200 |
| 41 | model_has_roles | Settings | Pivot | 10k |
| 42 | model_has_permissions | Settings | Pivot | 5k |
| 43 | role_has_permissions | Settings | Pivot | 2k |
| 44 | system_settings | Settings | Core | 100 |
| 45 | audit_logs | Audit | Core | 5M/yr |
| 46 | report_definitions | Report | Reference | 50 |
| 47 | generated_reports | Report | Child | 5k/yr |
| 48 | report_schedules | Report | Child | 100 |
| 49 | analytics_cache | Analytics | Cache | 200 |
| 50 | analytics_headcount_history | Analytics | Materialized | 3k/yr |
| 51 | analytics_leave_summary | Analytics | Materialized | 12k/yr |
| 52 | analytics_recruitment_funnel | Analytics | Materialized | 6k/yr |

## 8.2 Database Configuration

```php
// config/database.php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'hris'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'strict' => true,
    'engine' => 'InnoDB',
],

'redis' => [
    'client' => env('REDIS_CLIENT', 'phpredis'),
    'options' => ['prefix' => env('REDIS_PREFIX', 'hris:')],
    'default' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_DB', '0'),
    ],
    'cache' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_CACHE_DB', '1'),
    ],
    'queue' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_QUEUE_DB', '2'),
    ],
],
```

## 8.3 MySQL Indexing Strategy

| Table | Index | Type | Purpose |
|-------|-------|------|---------|
| audit_logs | (created_at) | RANGE PARTITION | Year-based archiving |
| audit_logs | (event, module, created_at) | COMPOSITE | Fast audit queries |
| attendance_records | (employee_id, date) | UNIQUE | Daily attendance lookup |
| leave_requests | (employee_id, status) | COMPOSITE | Leave status queries |
| payroll_runs | (status, period_start) | COMPOSITE | Active payroll lookups |
| employees | (first_name, last_name) | FULLTEXT | Employee search |
| notifications | (notifiable_type, notifiable_id, created_at) | COMPOSITE | User notification feed |

## 8.4 Migration Strategy

```bash
# Sequential migration execution
php artisan migrate --step

# Seed default data (roles, permissions, settings)
php artisan db:seed --class=Database\\Seeders\\Auth\\RolesAndPermissionsSeeder
php artisan db:seed --class=Database\\Seeders\\Settings\\SystemSettingsSeeder
php artisan db:seed --class=Database\\Seeders\\Attendance\\DefaultSchedulesSeeder
php artisan db:seed --class=Database\\Seeders\\Leave\\DefaultLeaveTypesSeeder
php artisan db:seed --class=Database\\Seeders\\Recruitment\\DefaultStagesSeeder
php artisan db:seed --class=Database\\Seeders\\Report\\DefaultReportDefinitionsSeeder
```
# 9. API Endpoint Design

## 9.1 API Standards

**Base URL:** `/api/v1`

**Headers:**
```
Accept: application/json
Content-Type: application/json
Authorization: Bearer {token}
X-Request-ID: {uuid}  (optional, for tracing)
X-Idempotency-Key: {uuid}  (for POST/PUT idempotency)
```

**Response Format (Success):**
```json
{
    "success": true,
    "data": { ... },
    "message": "Resource retrieved successfully.",
    "meta": {
        "current_page": 1,
        "last_page": 10,
        "per_page": 15,
        "total": 150,
        "from": 1,
        "to": 15
    }
}
```

**Response Format (Error):**
```json
{
    "success": false,
    "message": "Validation failed.",
    "errors": {
        "email": ["The email field is required."]
    },
    "code": "VALIDATION_ERROR"
}
```

**Pagination Parameters:**
```
?page=1&per_page=15&sort=created_at&direction=desc
```

**Filter Parameters:**
```
?search=john&department_id=1&status=active
```

**Include Relationships:**
```
?with=department,position,user
```

## 9.2 Complete API Endpoint Catalog

### Authentication (15 endpoints)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | /api/v1/auth/login | Login with email/password |
| POST | /api/v1/auth/login/sso | SSO login |
| POST | /api/v1/auth/logout | Logout current session |
| POST | /api/v1/auth/logout/all | Logout all devices |
| POST | /api/v1/auth/forgot-password | Request password reset |
| POST | /api/v1/auth/reset-password | Reset password |
| POST | /api/v1/auth/refresh | Refresh token |
| GET | /api/v1/auth/profile | Get profile |
| PUT | /api/v1/auth/profile | Update profile |
| PUT | /api/v1/auth/password | Change password |
| POST | /api/v1/auth/2fa/enable | Enable 2FA |
| POST | /api/v1/auth/2fa/disable | Disable 2FA |
| POST | /api/v1/auth/2fa/verify | Verify 2FA code |
| GET | /api/v1/auth/sessions | Active sessions |
| DELETE | /api/v1/auth/sessions/{id} | Terminate session |

**Total: 15 endpoints**

### Dashboard (4 endpoints)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/v1/dashboard | User dashboard |
| GET | /api/v1/dashboard/widgets | Widget list |
| PUT | /api/v1/dashboard/widgets | Configure widgets |
| GET | /api/v1/dashboard/metrics | HR metrics |

**Total: 4 endpoints**

### Employee (15 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/employees |
| POST | /api/v1/employees |
| GET | /api/v1/employees/{id} |
| PUT | /api/v1/employees/{id} |
| DELETE | /api/v1/employees/{id} |
| POST | /api/v1/employees/{id}/restore |
| DELETE | /api/v1/employees/{id}/force |
| GET | /api/v1/employees/export |
| POST | /api/v1/employees/import |
| GET | /api/v1/employees/template |
| POST | /api/v1/employees/{id}/documents |
| GET | /api/v1/employees/{id}/documents |
| DELETE | /api/v1/employees/{id}/documents/{docId} |
| GET | /api/v1/employees/{id}/history |
| GET | /api/v1/employees/{id}/timeline |

**Total: 15 endpoints**

### Department (6 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/departments |
| POST | /api/v1/departments |
| GET | /api/v1/departments/{id} |
| PUT | /api/v1/departments/{id} |
| DELETE | /api/v1/departments/{id} |
| GET | /api/v1/departments/tree |

**Total: 6 endpoints**

### Position (5 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/positions |
| POST | /api/v1/positions |
| GET | /api/v1/positions/{id} |
| PUT | /api/v1/positions/{id} |
| DELETE | /api/v1/positions/{id} |

**Total: 5 endpoints**

### Attendance (11 endpoints)

| Method | Endpoint |
|--------|----------|
| POST | /api/v1/attendance/clock-in |
| POST | /api/v1/attendance/clock-out |
| GET | /api/v1/attendance/today |
| GET | /api/v1/attendance |
| GET | /api/v1/attendance/{id} |
| PUT | /api/v1/attendance/{id} |
| GET | /api/v1/attendance/summary |
| GET | /api/v1/attendance/report |
| POST | /api/v1/attendance/import |
| GET | /api/v1/attendance/my-schedule |
| GET | /api/v1/attendance/holidays |

**Total: 11 endpoints**

### Leave (16 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/leave-requests |
| POST | /api/v1/leave-requests |
| GET | /api/v1/leave-requests/{id} |
| PUT | /api/v1/leave-requests/{id} |
| DELETE | /api/v1/leave-requests/{id} |
| POST | /api/v1/leave-requests/{id}/approve |
| POST | /api/v1/leave-requests/{id}/reject |
| GET | /api/v1/leave-balances |
| GET | /api/v1/leave-balances/{employeeId} |
| GET | /api/v1/leave-types |
| POST | /api/v1/leave-types |
| PUT | /api/v1/leave-types/{id} |
| GET | /api/v1/leave/calendar |
| GET | /api/v1/leave/report |
| POST | /api/v1/leave/import |
| GET | /api/v1/leave-requests/export |

**Total: 16 endpoints**

### Payroll (17 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/payroll/runs |
| POST | /api/v1/payroll/runs |
| GET | /api/v1/payroll/runs/{id} |
| POST | /api/v1/payroll/runs/{id}/process |
| POST | /api/v1/payroll/runs/{id}/complete |
| POST | /api/v1/payroll/runs/{id}/cancel |
| GET | /api/v1/payroll/runs/{id}/preview |
| GET | /api/v1/payroll/runs/{id}/payslips |
| GET | /api/v1/payroll/payslips |
| GET | /api/v1/payroll/payslips/{id} |
| GET | /api/v1/payroll/payslips/{id}/download |
| GET | /api/v1/payroll/components |
| POST | /api/v1/payroll/components |
| PUT | /api/v1/payroll/components/{id} |
| GET | /api/v1/payroll/report |
| POST | /api/v1/payroll/adjustments |
| GET | /api/v1/payroll/export/journal |

**Total: 17 endpoints**

### Recruitment (12 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/recruitment/jobs |
| POST | /api/v1/recruitment/jobs |
| GET | /api/v1/recruitment/jobs/{id} |
| PUT | /api/v1/recruitment/jobs/{id} |
| DELETE | /api/v1/recruitment/jobs/{id} |
| GET | /api/v1/recruitment/candidates |
| POST | /api/v1/recruitment/candidates |
| GET | /api/v1/recruitment/candidates/{id} |
| PUT | /api/v1/recruitment/candidates/{id} |
| POST | /api/v1/recruitment/candidates/{id}/stage |
| POST | /api/v1/recruitment/candidates/{id}/offer |
| GET | /api/v1/recruitment/pipeline |

**Total: 12 endpoints**

### Performance Review (12 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/performance/cycles |
| POST | /api/v1/performance/cycles |
| PUT | /api/v1/performance/cycles/{id} |
| POST | /api/v1/performance/cycles/{id}/launch |
| GET | /api/v1/performance/reviews |
| POST | /api/v1/performance/reviews |
| PUT | /api/v1/performance/reviews/{id} |
| POST | /api/v1/performance/reviews/{id}/submit |
| GET | /api/v1/performance/goals |
| POST | /api/v1/performance/goals |
| PUT | /api/v1/performance/goals/{id} |
| DELETE | /api/v1/performance/goals/{id} |

**Total: 12 endpoints**

### Announcement (7 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/announcements |
| POST | /api/v1/announcements |
| GET | /api/v1/announcements/{id} |
| PUT | /api/v1/announcements/{id} |
| DELETE | /api/v1/announcements/{id} |
| POST | /api/v1/announcements/{id}/pin |
| POST | /api/v1/announcements/{id}/read |

**Total: 7 endpoints**

### Notification (5 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/notifications |
| GET | /api/v1/notifications/unread-count |
| POST | /api/v1/notifications/{id}/read |
| POST | /api/v1/notifications/read-all |
| PUT | /api/v1/notifications/preferences |

**Total: 5 endpoints**

### Settings (12 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/settings/company |
| PUT | /api/v1/settings/company |
| GET | /api/v1/settings/general |
| PUT | /api/v1/settings/general |
| GET | /api/v1/roles |
| POST | /api/v1/roles |
| PUT | /api/v1/roles/{id} |
| DELETE | /api/v1/roles/{id} |
| GET | /api/v1/roles/{id}/permissions |
| PUT | /api/v1/roles/{id}/permissions |
| GET | /api/v1/permissions |
| PUT | /api/v1/users/{id}/roles |

**Total: 12 endpoints**

### Audit Log (3 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/audit-logs |
| GET | /api/v1/audit-logs/{id} |
| GET | /api/v1/audit-logs/export |

**Total: 3 endpoints**

### Report (9 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/reports |
| POST | /api/v1/reports/generate |
| GET | /api/v1/reports/generated |
| GET | /api/v1/reports/generated/{id} |
| DELETE | /api/v1/reports/generated/{id} |
| GET | /api/v1/reports/schedules |
| POST | /api/v1/reports/schedules |
| PUT | /api/v1/reports/schedules/{id} |
| DELETE | /api/v1/reports/schedules/{id} |

**Total: 9 endpoints**

### Analytics (8 endpoints)

| Method | Endpoint |
|--------|----------|
| GET | /api/v1/analytics/headcount |
| GET | /api/v1/analytics/turnover |
| GET | /api/v1/analytics/attendance |
| GET | /api/v1/analytics/leave |
| GET | /api/v1/analytics/payroll |
| GET | /api/v1/analytics/recruitment |
| GET | /api/v1/analytics/performance |
| GET | /api/v1/analytics/overview |

**Total: 8 endpoints**

### API Summary

| Module | Endpoints |
|--------|-----------|
| Authentication | 15 |
| Dashboard | 4 |
| Employee | 15 |
| Department | 6 |
| Position | 5 |
| Attendance | 11 |
| Leave | 16 |
| Payroll | 17 |
| Recruitment | 12 |
| Performance | 12 |
| Announcement | 7 |
| Notification | 5 |
| Settings | 12 |
| Audit Log | 3 |
| Report | 9 |
| Analytics | 8 |
| **Total** | **156 endpoints** |

---

# 10. Folder Structure

```
hris/
+-- app/
|   +-- Console/
|   |   +-- Commands/
|   |   |   +-- Attendance/
|   |   |   |   +-- AutoClockOutInactive.php
|   |   |   +-- Leave/
|   |   |   |   +-- ResetAnnualLeaveBalance.php
|   |   |   +-- Payroll/
|   |   |   |   +-- ProcessScheduledPayroll.php
|   |   |   +-- Report/
|   |   |   |   +-- GenerateScheduledReports.php
|   |   |   +-- Analytics/
|   |   |   |   +-- AggregateAnalyticsData.php
|   |   |   +-- System/
|   |   |       +-- ArchiveOldAuditLogs.php
|   |   |       +-- CleanupExpiredData.php
|   |   +-- Kernel.php
|   +-- Enums/
|   |   +-- EmployeeStatus.php
|   |   +-- LeaveStatus.php
|   |   +-- PayrollStatus.php
|   |   +-- AttendanceStatus.php
|   |   +-- NotificationChannel.php
|   +-- Exceptions/
|   |   +-- Handler.php
|   |   +-- BaseException.php
|   |   +-- BusinessRuleException.php
|   |   +-- ValidationException.php
|   |   +-- NotFoundException.php
|   |   +-- UnauthorizedException.php
|   +-- Http/
|   |   +-- Controllers/
|   |   |   +-- Api/
|   |   |   |   +-- V1/
|   |   |   |       +-- AuthController.php
|   |   |   |       +-- DashboardController.php
|   |   |   |       +-- EmployeeController.php
|   |   |   |       +-- DepartmentController.php
|   |   |   |       +-- PositionController.php
|   |   |   |       +-- AttendanceController.php
|   |   |   |       +-- LeaveRequestController.php
|   |   |   |       +-- LeaveTypeController.php
|   |   |   |       +-- PayrollRunController.php
|   |   |   |       +-- PayslipController.php
|   |   |   |       +-- PayrollComponentController.php
|   |   |   |       +-- RecruitmentJobController.php
|   |   |   |       +-- CandidateController.php
|   |   |   |       +-- PerformanceCycleController.php
|   |   |   |       +-- PerformanceReviewController.php
|   |   |   |       +-- GoalController.php
|   |   |   |       +-- AnnouncementController.php
|   |   |   |       +-- NotificationController.php
|   |   |   |       +-- RoleController.php
|   |   |   |       +-- PermissionController.php
|   |   |   |       +-- CompanySettingController.php
|   |   |   |       +-- SystemSettingController.php
|   |   |   |       +-- AuditLogController.php
|   |   |   |       +-- ReportController.php
|   |   |   |       +-- AnalyticsController.php
|   |   |   +-- Web/
|   |   |       +-- ... (Blade/Inertia controllers)
|   |   +-- Middleware/
|   |   |   +-- ForceJsonResponse.php
|   |   |   +-- LogRequestResponse.php
|   |   |   +-- SetRequestId.php
|   |   +-- Requests/
|   |   |   +-- Auth/
|   |   |   |   +-- LoginRequest.php
|   |   |   |   +-- RegisterRequest.php
|   |   |   |   +-- ForgotPasswordRequest.php
|   |   |   |   +-- ResetPasswordRequest.php
|   |   |   |   +-- UpdateProfileRequest.php
|   |   |   |   +-- ChangePasswordRequest.php
|   |   |   +-- Employee/
|   |   |   |   +-- StoreEmployeeRequest.php
|   |   |   |   +-- UpdateEmployeeRequest.php
|   |   |   |   +-- ImportEmployeeRequest.php
|   |   |   |   +-- UploadDocumentRequest.php
|   |   |   +-- Leave/
|   |   |   |   +-- StoreLeaveRequestRequest.php
|   |   |   |   +-- ApproveLeaveRequest.php
|   |   |   +-- Payroll/
|   |   |   |   +-- CreatePayrollRunRequest.php
|   |   |   |   +-- CreateAdjustmentRequest.php
|   |   |   +-- ... (one request per write endpoint)
|   |   +-- Resources/
|   |   |   +-- Auth/
|   |   |   |   +-- UserResource.php
|   |   |   |   +-- AuthResource.php
|   |   |   +-- Employee/
|   |   |   |   +-- EmployeeResource.php
|   |   |   |   +-- EmployeeCollection.php
|   |   |   |   +-- DocumentResource.php
|   |   |   +-- Department/
|   |   |   |   +-- DepartmentResource.php
|   |   |   +-- ... (one resource per model)
|   +-- Models/
|   |   +-- User.php
|   |   +-- Employee.php
|   |   +-- EmployeeDocument.php
|   |   +-- Department.php
|   |   +-- Position.php
|   |   +-- AttendanceRecord.php
|   |   +-- WorkSchedule.php
|   |   +-- EmployeeSchedule.php
|   |   +-- Holiday.php
|   |   +-- LeaveType.php
|   |   +-- LeaveBalance.php
|   |   +-- LeaveRequest.php
|   |   +-- LeaveApproval.php
|   |   +-- PayrollComponent.php
|   |   +-- EmployeePayrollComponent.php
|   |   +-- PayrollRun.php
|   |   +-- Payslip.php
|   |   +-- PayslipDetail.php
|   |   +-- PayrollAdjustment.php
|   |   +-- JobPosting.php
|   |   +-- HiringManager.php
|   |   +-- RecruitmentStage.php
|   |   +-- Candidate.php
|   |   +-- CandidateStageLog.php
|   |   +-- OfferLetter.php
|   |   +-- ReviewCycle.php
|   |   +-- PerformanceReview.php
|   |   +-- ReviewSection.php
|   |   +-- Goal.php
|   |   +-- Announcement.php
|   |   +-- AnnouncementAudience.php
|   |   +-- AnnouncementRead.php
|   |   +-- NotificationPreference.php
|   |   +-- CompanyProfile.php
|   |   +-- Role.php
|   |   +-- Permission.php
|   |   +-- SystemSetting.php
|   |   +-- AuditLog.php
|   |   +-- ReportDefinition.php
|   |   +-- GeneratedReport.php
|   |   +-- ReportSchedule.php
|   |   +-- AnalyticsCache.php
|   |   +-- AnalyticsHeadcountHistory.php
|   |   +-- AnalyticsLeaveSummary.php
|   |   +-- Traits/
|   |       +-- HasEmployeeRelation.php
|   |       +-- HasAuditLog.php
|   |       +-- HasStatusScope.php
|   |       +-- Filterable.php
|   |       +-- Exportable.php
|   |       +-- Importable.php
|   +-- Services/
|   |   +-- Auth/
|   |   |   +-- AuthenticationService.php
|   |   |   +-- TwoFactorService.php
|   |   |   +-- SsoService.php
|   |   +-- Employee/
|   |   |   +-- EmployeeService.php
|   |   |   +-- EmployeeImportService.php
|   |   |   +-- EmployeeDocumentService.php
|   |   +-- Attendance/
|   |   |   +-- AttendanceService.php
|   |   |   +-- ScheduleService.php
|   |   +-- Leave/
|   |   |   +-- LeaveService.php
|   |   |   +-- LeaveBalanceService.php
|   |   |   +-- LeaveApprovalWorkflow.php
|   |   +-- Payroll/
|   |   |   +-- PayrollService.php
|   |   |   +-- PayrollCalculationService.php
|   |   |   +-- TaxCalculationService.php
|   |   |   +-- PayslipGenerationService.php
|   |   +-- Recruitment/
|   |   |   +-- RecruitmentService.php
|   |   |   +-- CandidatePipelineService.php
|   |   |   +-- OfferLetterService.php
|   |   +-- Performance/
|   |   |   +-- PerformanceService.php
|   |   |   +-- ReviewCycleService.php
|   |   +-- Notification/
|   |   |   +-- NotificationService.php
|   |   +-- Report/
|   |   |   +-- ReportService.php
|   |   |   +-- ReportGenerationService.php
|   |   +-- Analytics/
|   |   |   +-- AnalyticsService.php
|   |   |   +-- AnalyticsAggregationService.php
|   |   +-- Audit/
|   |   |   +-- AuditService.php
|   |   +-- Dashboard/
|   |   |   +-- DashboardService.php
|   |   +-- Settings/
|   |   |   +-- RoleService.php
|   |   |   +-- PermissionService.php
|   |   |   +-- SystemSettingService.php
|   +-- Repositories/
|   |   +-- Contracts/
|   |   |   +-- EmployeeRepositoryInterface.php
|   |   |   +-- DepartmentRepositoryInterface.php
|   |   |   +-- LeaveRequestRepositoryInterface.php
|   |   |   +-- AttendanceRepositoryInterface.php
|   |   |   +-- PayrollRunRepositoryInterface.php
|   |   |   +-- ... (one per core model)
|   |   +-- EmployeeRepository.php
|   |   +-- DepartmentRepository.php
|   |   +-- LeaveRequestRepository.php
|   |   +-- AttendanceRepository.php
|   |   +-- PayrollRunRepository.php
|   |   +-- ... (implementations)
|   +-- Jobs/
|   |   +-- ProcessPayrollJob.php
|   |   +-- GeneratePayslipPdfJob.php
|   |   +-- SendEmailNotificationJob.php
|   |   +-- ProcessLeaveApprovalJob.php
|   |   +-- ImportEmployeesJob.php
|   |   +-- GenerateReportJob.php
|   |   +-- AggregateAnalyticsJob.php
|   +-- Listeners/
|   |   +-- LogAuditListener.php
|   |   +-- SendNotificationListener.php
|   |   +-- UpdateLeaveBalanceListener.php
|   |   +-- SyncDepartmentHeadcountListener.php
|   +-- Events/
|   |   +-- EmployeeCreated.php
|   |   +-- EmployeeUpdated.php
|   |   +-- LeaveRequested.php
|   |   +-- LeaveApproved.php
|   |   +-- LeaveRejected.php
|   |   +-- PayrollCompleted.php
|   |   +-- ... (one per auditable event)
|   +-- Observers/
|   |   +-- EmployeeObserver.php
|   |   +-- LeaveRequestObserver.php
|   |   +-- PayslipObserver.php
|   |   +-- ModelObserver.php (generic audit)
|   +-- Rules/
|   |   +-- ValidLeaveBalance.php
|   |   +-- ValidDateRange.php
|   |   +-- NoOverlappingLeave.php
|   |   +-- EmployeeExists.php
|   +-- Exports/
|   |   +-- EmployeesExport.php
|   |   +-- AttendanceExport.php
|   |   +-- LeaveExport.php
|   |   +-- PayrollExport.php
|   +-- Imports/
|   |   +-- EmployeesImport.php
|   |   +-- AttendanceImport.php
|   +-- Providers/
|   |   +-- AppServiceProvider.php
|   |   +-- RepositoryServiceProvider.php
|   |   +-- HorizonServiceProvider.php
|   |   +-- FortifyServiceProvider.php
+-- bootstrap/
+-- config/
|   +-- hris.php (custom HRIS config)
|   +-- module.php (module registration)
+-- database/
|   +-- factories/
|   |   +-- EmployeeFactory.php
|   |   +-- ... (one per model)
|   +-- migrations/
|   |   +-- 0001_01_01_000000_create_users_table.php
|   |   +-- 0001_01_01_000001_create_departments_table.php
|   |   +-- ... (52 migrations)
|   +-- seeders/
|   |   +-- DatabaseSeeder.php
|   |   +-- RolesAndPermissionsSeeder.php
|   |   +-- DemoDataSeeder.php
|   |   +-- SystemSettingsSeeder.php
+-- routes/
|   +-- api.php (API routes)
|   +-- web.php (web routes)
|   +-- channels.php (broadcast channels)
+-- storage/
|   +-- app/
|   |   +-- public/
|   |   |   +-- documents/
|   |   |   +-- payslips/
|   |   |   +-- reports/
|   |   |   +-- avatars/
|   |   +-- exports/
|   |   +-- imports/
|   +-- logs/
+-- tests/
|   +-- Unit/
|   |   +-- Services/
|   |   |   +-- PayrollCalculationServiceTest.php
|   |   |   +-- LeaveBalanceServiceTest.php
|   |   +-- Rules/
|   |   |   +-- ValidLeaveBalanceRuleTest.php
|   +-- Feature/
|   |   +-- Http/
|   |   |   +-- Api/
|   |   |       +-- V1/
|   |   |           +-- EmployeeApiTest.php
|   |   |           +-- LeaveRequestApiTest.php
|   |   |           +-- PayrollApiTest.php
|   |   +-- Jobs/
|   |       +-- ProcessPayrollJobTest.php
|   +-- TestCase.php
+-- resources/
|   +-- js/ (Vue/Inertia)
|   |   +-- Components/
|   |   +-- Layouts/
|   |   +-- Pages/
|   |   |   +-- Auth/
|   |   |   +-- Dashboard/
|   |   |   +-- Employees/
|   |   |   +-- Departments/
|   |   |   +-- Attendance/
|   |   |   +-- Leave/
|   |   |   +-- Payroll/
|   |   |   +-- Recruitment/
|   |   |   +-- Performance/
|   |   |   +-- Settings/
|   |   |   +-- Reports/
|   |   +-- Composables/
|   |   |   +-- useAuth.js
|   |   |   +-- useNotification.js
|   |   |   +-- usePermission.js
|   |   +-- Stores/
|   |       +-- auth.js
|   |       +-- app.js
|   +-- css/
|   |   +-- app.css (Tailwind)
|   +-- views/
+-- docs/
|   +-- PRD.md
|   +-- api-reference.md
+-- docker/
|   +-- Dockerfile
|   +-- docker-compose.yml
|   +-- nginx/
+-- .github/
|   +-- workflows/
|       +-- ci.yml
|       +-- deploy.yml
+-- composer.json
+-- package.json
+-- vite.config.js
+-- tailwind.config.js
```
# 11. Laravel Architecture

## 11.1 Technology Stack Decision

### Frontend Recommendation: Inertia + Vue 3

**Why Inertia + Vue 3 over Blade + Livewire:**

| Factor | Blade + Livewire | Inertia + Vue 3 |
|--------|-----------------|-----------------|
| UX / Interactivity | Good (Livewire polling) | Excellent (true SPA) |
| Development Speed | Fast | Medium |
| Reusable Components | Limited | Vue components |
| State Management | Livewire per component | Pinia global store |
| TypeScript Support | Limited | Full support |
| Mobile Experience | Livewire polling drains battery | Efficient API calls |
| Complex UI (drag-drop, charts) | Difficult | Natural |
| Learning Curve | Low (PHP devs) | Medium |
| Team Scalability | PHP + Alpine | PHP + Vue separation |

**Recommendation: Inertia + Vue 3** for enterprise-grade UX, better component reusability, and true SPA experience without the complexity of a full decoupled SPA.

### Supporting Libraries

| Library | Purpose |
|---------|---------|
| Laravel Fortify | Authentication scaffolding |
| Laravel Permissions (spatie/laravel-permission) | RBAC |
| Laravel Excel (maatwebsite/laravel-excel) | Import/Export |
| Laravel Horizon | Queue monitoring |
| Laravel Telescope | Debugging & monitoring (dev) |
| Laravel Debugbar | Performance profiling (dev) |
| barryvdh/laravel-dompdf | PDF generation (payslips) |
| Laravel Scout | Full-text search (MeiliSearch/TNTSearch) |
| Laravel Backup (spatie) | Database & file backup |
| Intervention Image | Image manipulation (avatars) |
| Vue 3 + Pinia | Frontend framework & state |
| Tailwind CSS + Headless UI | Styling & accessible components |
| Recharts / Chart.js | Analytics charts |
| Laravel Sanctum | API authentication |

## 11.2 Architecture Patterns

### Request Lifecycle

```
Browser (SPA)
  |
  v
Nginx (load balancer)
  |
  v
Laravel App (horizontal scale)
  |
  +-> Redis (cache, session, queue)
  |
  +-> MySQL (primary)
  |     +-> Read Replica (reports, analytics)
  |
  +-> S3/MinIO (document storage)
  |
  +-> Mail (email notifications)
  |
  +-> Queue Workers (Horizon)
        +-> ProcessPayrollJob
        +-> GeneratePayslipPdfJob
        +-> SendEmailNotificationJob
        +-> ImportEmployeesJob
        +-> GenerateReportJob
```

### Module Structure Pattern

Each module follows a consistent layered architecture:

```
Module/
+-- Controllers/    (HTTP layer - thin)
+-- Requests/       (Validation)
+-- Resources/      (Response transformation)
+-- Services/       (Business logic)
+-- Repositories/   (Data access)
+-- Models/         (Eloquent)
+-- Jobs/           (Async tasks)
+-- Events/         (Event definitions)
+-- Listeners/      (Event handlers)
+-- Rules/          (Custom validation rules)
+-- Exports/        (Report generation)
+-- Imports/        (Bulk data import)
+-- Enums/          (Type definitions)
+-- Tests/          (Module tests)
```

### Service Layer Pattern

Controllers are thin. All business logic lives in Services.

```
Controller -> FormRequest (validation)
   -> Service (business logic, orchestrates repositories)
      -> Repository (data access, query logic)
         -> Model (Eloquent ORM)
      -> Events (dispatch for side effects)
         -> Listeners (notifications, audit, sync)
      -> Jobs (queue async work)
   -> Resource (response transformation)
```

### Example: Leave Request Flow

```php
// Controller
class LeaveRequestController extends Controller
{
    public function store(StoreLeaveRequestRequest $request, LeaveService $service)
    {
        $leaveRequest = $service->createLeaveRequest(
            $request->user()->employee,
            $request->validated()
        );
        return new LeaveRequestResource($leaveRequest);
    }
}

// Service
class LeaveService
{
    public function __construct(
        private LeaveRequestRepository $repository,
        private LeaveBalanceService $balanceService,
        private LeaveApprovalWorkflow $approvalWorkflow,
        private NotificationService $notificationService,
        private AuditService $auditService,
    ) {}

    public function createLeaveRequest(Employee $employee, array $data): LeaveRequest
    {
        // 1. Validate business rules
        $this->balanceService->validateSufficientBalance($employee, $data['leave_type_id'], $data['total_days']);
        $this->validateNoOverlappingLeave($employee, $data['start_date'], $data['end_date']);
        $this->validateDateRangePolicy($data['start_date'], $data['end_date']);

        // 2. Create leave request
        $leaveRequest = $this->repository->create([
            'employee_id' => $employee->id,
            'leave_type_id' => $data['leave_type_id'],
            'uuid' => Str::uuid(),
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'total_days' => $data['total_days'],
            'reason' => $data['reason'],
            'status' => LeaveStatus::PENDING,
        ]);

        // 3. Update balance (pending)
        $this->balanceService->reserveDays($employee, $data['leave_type_id'], $data['total_days']);

        // 4. Start approval workflow
        $this->approvalWorkflow->initiate($leaveRequest);

        // 5. Dispatch events (async)
        event(new LeaveRequested($leaveRequest));

        return $leaveRequest;
    }
}
```

---

# 12. Service Layer

## 12.1 Service Layer Responsibilities

| Responsibility | Description |
|----------------|-------------|
| Business Logic | All domain rules and calculations |
| Orchestration | Coordinate multiple repositories and services |
| Transaction Management | Database transactions for multi-step operations |
| Event Dispatching | Fire events for cross-cutting concerns |
| Authorization Checks | Gate checks beyond simple permissions |
| Data Transformation | Prepare data for controllers/resources |

## 12.2 Core Services

### AuthenticationService
- Login handling with rate limiting
- Token management (create, revoke, refresh)
- 2FA verification flow
- SSO integration
- Session management

### EmployeeService
- Employee creation with user account sync
- Profile update with field-level audit
- Employment status transitions
- Document management
- Import/Export orchestration

### AttendanceService
- Clock in/out with geolocation validation
- Timesheet calculation (regular, overtime, late)
- Schedule assignment and validation
- Holiday calendar management

### LeaveService
- Leave request creation with balance validation
- Multi-level approval workflow
- Balance calculation and adjustment
- Leave calendar generation

### PayrollService
- Payroll run creation and processing
- Salary calculation (earnings, deductions, tax)
- Payslip generation and PDF export
- Adjustment processing
- Journal entry generation

### PayrollCalculationService
- Gross salary calculation from components
- Overtime pay calculation (1.5x, 2x rates)
- Tax bracket calculation
- Statutory deduction computation
- Net salary finalization

### RecruitmentService
- Job posting lifecycle management
- Candidate pipeline management
- Stage transitions with logging
- Offer letter generation

### PerformanceService
- Review cycle management
- 360-review assignment and tracking
- Goal setting and progress tracking
- Rating calculation and aggregation

### ReportService
- Report definition management
- Report generation (sync for small, queue for large)
- Multi-format export (CSV, Excel, PDF)
- Scheduled report dispatch

### AnalyticsService
- Headcount trend calculation
- Turnover rate computation
- Leave pattern analysis
- Recruitment funnel metrics
- Payroll cost analysis

### NotificationService
- Multi-channel notification dispatch
- Preference-based routing
- Email template rendering
- Digest generation

### AuditService
- Event logging with before/after values
- Audit log query and export
- Data retention and archiving

### DashboardService
- Role-based widget aggregation
- Metric calculation with caching
- Widget configuration management

## 12.3 Service Layer Best Practices

```php
// 1. Single Responsibility - each service focuses on one domain
class LeaveService { /* Only leave-related logic */ }

// 2. Dependency Injection via constructor
class PayrollService
{
    public function __construct(
        private PayrollCalculationService $calculator,
        private TaxCalculationService $taxCalculator,
        private PayslipGenerationService $payslipGenerator,
        private AuditService $audit,
    ) {}
}

// 3. Return typed objects, not arrays
public function calculatePayroll(PayrollRun $run): PayrollRun
{
    // Returns the updated PayrollRun model
}

// 4. Use DTOs for complex data transfer
public function processLeaveRequest(CreateLeaveDto $dto): LeaveRequest
{
    // DTO encapsulates validated data
}

// 5. Transaction management for multi-step operations
DB::transaction(function () use ($data) {
    $employee = $this->repository->create($data);
    $this->balanceService->initializeBalances($employee);
    event(new EmployeeCreated($employee));
});
```

---

# 13. Repository Pattern

## 13.1 Repository Responsibilities

| Responsibility | Description |
|----------------|-------------|
| Data Access | All database queries for the entity |
| Query Building | Complex queries with filters, sorting, pagination |
| Relationship Loading | Eager loading of related models |
| Soft Delete Handling | Trashed record queries |
| Bulk Operations | Batch insert/update/delete |

## 13.2 Repository Interface Contract

```php
interface RepositoryInterface
{
    public function all(array $columns = ['*']): Collection;
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;
    public function find(int $id): ?Model;
    public function findOrFail(int $id): Model;
    public function findBy(string $field, mixed $value): ?Model;
    public function create(array $data): Model;
    public function update(Model $model, array $data): Model;
    public function delete(Model $model): bool;
    public function restore(int $id): bool;
    public function forceDelete(int $id): bool;
    public function count(): int;
    public function exists(array $conditions): bool;
}
```

## 13.3 Example Repository

```php
class LeaveRequestRepository extends BaseRepository implements LeaveRequestRepositoryInterface
{
    public function __construct(protected LeaveRequest $model) {}

    public function findPendingByApprover(int $approverId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->whereHas('approvals', function ($query) use ($approverId) {
                $query->where('approver_id', $approverId)
                      ->where('status', 'pending')
                      ->where('level', function ($sub) {
                          $sub->selectRaw('MIN(level)')
                              ->from('leave_approvals')
                              ->whereColumn('leave_request_id', 'leave_requests.id');
                      });
            })
            ->with(['employee', 'leaveType'])
            ->paginate($perPage);
    }

    public function getByDateRange(int $employeeId, string $startDate, string $endDate): Collection
    {
        return $this->model
            ->where('employee_id', $employeeId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->whereIn('status', ['pending', 'approved'])
            ->get();
    }

    public function getCalendarData(int $employeeId, string $month, string $year): Collection
    {
        return $this->model
            ->where('employee_id', $employeeId)
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->where('status', 'approved')
            ->with('leaveType')
            ->get();
    }
}
```

## 13.4 Repository Binding

```php
// AppServiceProvider or dedicated RepositoryServiceProvider
public function register(): void
{
    $this->app->bind(LeaveRequestRepositoryInterface::class, LeaveRequestRepository::class);
    $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
    $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
    $this->app->bind(PayrollRunRepositoryInterface::class, PayrollRunRepository::class);
}
```

---

# 14. Queue & Job Flow

## 14.1 Queue Configuration

```
Connection: redis
Queue: hris-{env}
Default Tries: 3
Backoff: 30, 60, 120 (exponential)
Timeout: 300 seconds
Max Jobs: 1000 per worker
```

## 14.2 Horizon Configuration

```php
// config/horizon.php
'environments' => [
    'production' => [
        'supervisor-1' => [
            'connection' => 'redis',
            'queue' => ['high', 'default', 'low'],
            'balance' => 'auto',
            'minProcesses' => 1,
            'maxProcesses' => 20,
            'tries' => 3,
            'timeout' => 300,
        ],
    ],
    'local' => [
        'supervisor-1' => [
            'connection' => 'redis',
            'queue' => ['high', 'default', 'low'],
            'balance' => 'simple',
            'processes' => 3,
            'tries' => 3,
        ],
    ],
],
```

## 14.3 Queue Priority Tiers

| Queue | Priority | Jobs |
|-------|----------|------|
| high | Immediate | Email notifications, PDF generation |
| default | Standard | Payroll processing, report generation |
| low | Background | Analytics aggregation, log archiving |

## 14.4 Key Jobs

| Job | Queue | Description | Tries | Timeout |
|-----|-------|-------------|-------|---------|
| ProcessPayrollJob | default | Full payroll calculation for all employees | 1 | 600s |
| GeneratePayslipPdfJob | high | Generate individual payslip PDF | 3 | 60s |
| SendEmailNotificationJob | high | Send transactional email | 3 | 30s |
| ProcessLeaveApprovalJob | default | Multi-level leave approval chain | 3 | 30s |
| ImportEmployeesJob | default | Bulk employee CSV import | 1 | 300s |
| GenerateReportJob | low | Async report generation | 2 | 300s |
| AggregateAnalyticsJob | low | Analytics data aggregation | 2 | 120s |
| ArchiveOldAuditLogsJob | low | Archive audit logs to cold storage | 1 | 600s |

## 14.5 Payroll Processing Queue Flow

```
User clicks "Process Payroll"
  -> PayrollRunController@process
  -> PayrollService::processPayroll($run)
  -> Status: processing
  -> Dispatch: ProcessPayrollJob ($run->id)
  -> Return: 202 Accepted

ProcessPayrollJob::handle()
  -> For each active employee in period:
    -> Get basic salary
    -> Get allowances (percentage & fixed)
    -> Get attendance (days, OT, late)
    -> Calculate gross = basic + allowances + OT
    -> Calculate tax per bracket
    -> Calculate social security, insurance, pension
    -> Calculate net = gross - deductions
    -> Create Payslip record
    -> Create PayslipDetails records
  -> Update run totals
  -> Status: draft (ready for review)
  -> Dispatch: SendEmailNotificationJob (notify HR)

HR clicks "Complete Payroll"
  -> PayrollRunController@complete
  -> PayrollService::completePayroll($run)
  -> Status: completed
  -> For each payslip:
    -> Dispatch: GeneratePayslipPdfJob
    -> Dispatch: SendEmailNotificationJob (notify employee)
  -> Log audit: payroll.run.completed
```

## 14.6 Failed Job Handling

```php
// AppServiceProvider or HorizonServiceProvider
public function failed(Job $job, \Throwable $e): void
{
    Log::error('Job failed', [
        'job' => get_class($job),
        'uuid' => $job->uuid(),
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);

    // Notify admin if critical job fails
    if ($job instanceof ProcessPayrollJob) {
        Notification::route('mail', config('hris.admin_email'))
            ->notify(new CriticalJobFailedNotification($job, $e));
    }
}
```

---

# 15. Scheduler Flow

## 15.1 Cron Schedule

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule): void
{
    // Daily at midnight - Auto clock-out inactive employees
    $schedule->job(new AutoClockOutInactiveJob())
        ->dailyAt('00:00')
        ->withoutOverlapping()
        ->onOneServer()
        ->description('Auto clock-out employees who forgot');

    // Daily at 00:30 - Aggregate analytics data
    $schedule->job(new AggregateAnalyticsJob())
        ->dailyAt('00:30')
        ->withoutOverlapping()
        ->onOneServer()
        ->description('Aggregate daily analytics metrics');

    // Daily at 01:00 - Archive old soft-deleted records
    $schedule->job(new CleanupExpiredDataJob())
        ->dailyAt('01:00')
        ->withoutOverlapping()
        ->description('Cleanup expired sessions, tokens, temp data');

    // Daily at 02:00 - Generate scheduled reports
    $schedule->command('reports:generate-scheduled')
        ->dailyAt('02:00')
        ->withoutOverlapping()
        ->description('Generate and email scheduled reports');

    // Daily at 03:00 - Archive old audit logs
    $schedule->job(new ArchiveOldAuditLogsJob())
        ->dailyAt('03:00')
        ->withoutOverlapping()
        ->onOneServer()
        ->description('Archive audit logs older than retention period');

    // Every 15 minutes - Process pending notifications
    $schedule->job(new ProcessPendingNotificationsJob())
        ->everyFifteenMinutes()
        ->withoutOverlapping()
        ->description('Send queued notification emails');

    // Every hour - Check for scheduled announcements
    $schedule->command('announcements:publish-scheduled')
        ->hourly()
        ->withoutOverlapping()
        ->description('Publish scheduled announcements');

    // Daily - Check for expired documents and announcements
    $schedule->command('system:check-expirations')
        ->dailyAt('06:00')
        ->description('Check and handle expired records');

    // Monthly - Reset leave balances
    $schedule->job(new ResetAnnualLeaveBalanceJob())
        ->monthlyOn(1, '00:00')
        ->withoutOverlapping()
        ->onOneServer()
        ->description('Reset annual leave balances for new year');

    // Weekly - Database backup
    $schedule->command('backup:clean')
        ->weekly()
        ->description('Clean old backups');

    $schedule->command('backup:run')
        ->weekly()
        ->withoutOverlapping()
        ->description('Run database backup');
}
```

## 15.2 Scheduler Responsibilities

| Task | Frequency | Criticality | Description |
|------|-----------|-------------|-------------|
| Auto Clock-Out | Daily | High | Clock out employees who forgot at midnight |
| Analytics Aggregation | Daily | Medium | Refresh materialized analytics tables |
| Data Cleanup | Daily | Medium | Remove expired tokens, sessions, temp files |
| Scheduled Reports | Daily | Low | Generate and email scheduled reports |
| Audit Log Archive | Daily | Medium | Archive logs beyond retention to cold storage |
| Notifications | 15 min | Medium | Batch send pending email notifications |
| Announcements | Hourly | Low | Publish scheduled announcements |
| Expiry Checks | Daily | Low | Expire documents, announcements, offers |
| Leave Balance Reset | Monthly | High | Reset annual leave for new fiscal year |
| Backup | Weekly | High | Full database and storage backup |

## 15.3 Production Deployment

```bash
# Add to crontab on the application server
* * * * * cd /var/www/hris && php artisan schedule:run >> /dev/null 2>&1

# Supervisor configuration for queue workers
[program:horizon]
command=php /var/www/hris/artisan horizon
user=www-data
autostart=true
autorestart=true
startretries=3
stdout_logfile=/var/www/hris/storage/logs/horizon.log
stderr_logfile=/var/www/hris/storage/logs/horizon-error.log
```
# 16. Sequence Diagrams

## 16.1 Leave Request Flow

```
Employee            SPA (Vue)           API (Laravel)       Service Layer          DB            Manager
   |                    |                     |                   |                   |              |
   |-- Click Apply ---->|                     |                   |                   |              |
   |                    |-- POST /leave ----->|                   |                   |              |
   |                    |                     |-- validate ----->|                   |              |
   |                    |                     |                   |-- check balance ->|              |
   |                    |                     |                   |<-- balance ok ----|              |
   |                    |                     |                   |-- check overlap ->|              |
   |                    |                     |                   |<-- no overlap ----|              |
   |                    |                     |                   |-- create record ->|              |
   |                    |                     |                   |<-- record id -----|              |
   |                    |                     |                   |-- reserve balance>|              |
   |                    |                     |                   |-- initiate wf --->|              |
   |                    |                     |                   |-- dispatch event -|              |
   |                    |                     |<-- 201 Created ---|                   |              |
   |<-- Success toast --|                     |                   |                   |              |
   |                    |                     |                   |                   |-- Email ----->|
   |                    |                     |                   |                   |              |
   |                    |                     |                   |                   |-- Approve -->|
   |                    |                     |                   |                   |              |
   |                    |                     |<-- POST approve --|                   |              |
   |                    |<-- 200 OK ---------|                   |                   |              |
   |<-- Notification ---|                     |                   |                   |              |
   |                    |                     |                   |                   |              |
```

## 16.2 Payroll Processing Flow

```
HR/Finance          SPA (Vue)           API (Laravel)       Queue (Redis)      Workers          DB
   |                    |                     |                   |                 |              |
   |-- Create Run ----->|                     |                   |                 |              |
   |                    |-- POST /payroll --->|                   |                 |              |
   |                    |                     |-- validate ----->|                 |              |
   |                    |                     |<-- run created --|                 |              |
   |                    |                     |                   |                 |              |
   |-- Click Preview -->|                     |                   |                 |              |
   |                    |-- GET /preview ---->|                   |                 |              |
   |                    |                     |-- calc preview ->|                 |              |
   |                    |                     |<-- preview data -|                 |              |
   |<-- Preview shown --|                     |                   |                 |              |
   |                    |                     |                   |                 |              |
   |-- Click Process -->|                     |                   |                 |              |
   |                    |-- POST /process --->|                   |                 |              |
   |                    |                     |-- status=draft ->|                 |              |
   |                    |                     |-- dispatch ----->|-- JOB_QUEUED -->|              |
   |<-- 202 Accepted ---|                     |                   |                 |              |
   |                    |                     |                   |                 |-- pull ----->|
   |                    |                     |                   |                 |-- loop emp ->|
   |                    |                     |                   |                 |-- calc gross>|
   |                    |                     |                   |                 |-- calc tax ->|
   |                    |                     |                   |                 |-- calc net ->|
   |                    |                     |                   |                 |-- payslip ->|
   |                    |                     |                   |                 |-- repeat --->|
   |                    |                     |                   |                 |              |
   |                    |                     |<-- notification --|                 |              |
   |                    |                     |                   |                 |              |
   |-- Click Complete ->|                     |                   |                 |              |
   |                    |-- POST /complete -->|                   |                 |              |
   |                    |                     |-- status=done --->|                 |              |
   |                    |                     |-- dispatch PDF -->|-- PDF_JOBS ---->|              |
   |                    |                     |<-- payroll done -|                 |              |
   |                    |                     |                   |                 |-- gen PDF -->|
   |                    |                     |                   |                 |-- notify --->|
```

## 16.3 Employee Clock-In Flow

```
Employee            SPA (Vue)           API (Laravel)       Service            DB
   |                    |                     |                   |                 |
   |-- Click Clock-In ->|                     |                   |                 |
   |                    |-- POST /clock-in --->|                   |                 |
   |                    |  (lat, lng, photo)   |                   |                 |
   |                    |                     |-- validate ----->|                 |
   |                    |                     |-- check active ->|                 |
   |                    |                     |                   |-- is active? -->|
   |                    |                     |                   |<-- yes ---------|
   |                    |                     |-- check geo ----->|                 |
   |                    |                     |   (if enabled)    |                 |
   |                    |                     |-- check dup ----->|                 |
   |                    |                     |                   |-- already in? ->|
   |                    |                     |                   |<-- no ----------|
   |                    |                     |-- create rec ---->|                 |
   |                    |                     |                   |-- insert ------>|
   |                    |                     |                   |-- calc late --->|
   |                    |                     |<-- 201 Created ---|                 |
   |                    |                     |                   |                 |
   |                    |                     |-- dispatch event->|                 |
   |                    |                     |                   |-- audit log -->|
   |                    |                     |                   |                 |
   |<-- Success toast --|                     |                   |                 |
   |   "Clocked in at  |                     |                   |                 |
   |    08:32 AM"      |                     |                   |                 |
```

## 16.4 Leave Balance Reset Flow (Scheduler)

```
Cron            Laravel Scheduler       Command          Service            DB
 |                    |                     |                |                 |
 |-- Every 1 min ---->|                     |                |                 |
 |                    |-- evaluate tasks -->|                |                 |
 |                    |                     |                |                 |
 |                    |                     |-- Jan 1? --->|                 |
 |                    |                     |                |                 |
 |                    |                     |-- YES ------>|                 |
 |                    |                     |                |                 |
 |                    |                     |                |-- fetch emp -->|
 |                    |                     |                |<-- [employees]-|
 |                    |                     |                |                |
 |                    |                     |                |-- for each:
 |                    |                     |                |   - calc days
 |                    |                     |                |   - carry over
 |                    |                     |                |   - insert --->|
 |                    |                     |                |   - audit ---->|
 |                    |                     |                |                |
 |                    |                     |                |-- notify ---->| (queue)
 |                    |                     |                |                |
 |                    |                     |<-- completed -|                |
 |                    |<-- exit ------------|                |                |
```

---

# 17. Activity Diagrams

## 17.1 Leave Request Activity Diagram

```
+---------------------+
| Start: Employee     |
| submits leave       |
| request             |
+----------+----------+
           |
           v
+---------------------+
| Validate Request    |
| - Date range        |
| - Balance check     |
| - Policy rules      |
+----------+----------+
           |
     +-----+-----+
     |           |
     v           v
+---------+  +----------+
| Valid   |  | Invalid  |
+----+----+  +-----+----+
     |             |
     v             v
+---------+  +----------+
| Create  |  | Return   |
| Request |  | Errors   |
| (Pend.) |  +----------+
+----+----+
     |
     v
+---------------------+
| Notify Level 1      |
| Approver            |
+----------+----------+
           |
           v
+---------------------+
| Level 1 Approver    |
| Reviews             |
+----------+----------+
           |
     +-----+-----+
     |           |
     v           v
+---------+  +----------+
| Approve |  | Reject   |
+----+----+  +----+-----+
     |             |
     v             v
+---------+  +----------+
| More    |  | Cancel   |
| Levels? |  | Request  |
+----+----+  +----+-----+
     |             |
  +--+--+          v
  |     |     +----------+
  v     v     | Notify   |
 |YES  |NO   | Employee |
  |     |     +----------+
  v     v
+---+ +---------+
|Nxt | | Final:  |
|Lvl | | Approve |
+----+ +----+----+
     |      |
     v      v
+----------+ +---------+
| Repeat   | | Update  |
| Process  | | Balance |
+----------+ +----+----+
                  |
                  v
            +----------+
            | Notify   |
            | Employee |
            +----------+
                  |
                  v
            +----------+
            | End      |
            +----------+
```

## 17.2 Payroll Run Activity Diagram

```
+---------------------+
| Start: HR creates   |
| payroll run for     |
| period              |
+----------+----------+
           |
           v
+---------------------+
| Set Period:         |
| Start, End,         |
| Payment Date        |
+----------+----------+
           |
           v
+---------------------+
| Preview             |
| (Calculations shown |
| but not saved)      |
+----------+----------+
           |
     +-----+-----+
     |           |
     v           v
+---------+  +----------+
| Approve |  | Adjust   |
| Preview |  | Period   |
+----+----+  +-----+----+
     |             |
     v             v
+---------+  +----+-----+
| Process |  | Re-Preview|
| Payroll |  |           |
+----+----+  +----------+
     |
     v
+---------------------+
| Queue Job:          |
| Per-employee calc   |
| - Earnings          |
| - Deductions        |
| - Tax               |
| - Net Pay           |
+----------+----------+
           |
           v
+---------------------+
| Review Results      |
| (Status: Draft)     |
+----------+----------+
           |
     +-----+-----+
     |           |
     v           v
+---------+  +----------+
| Correct |  | Complete |
| & Fix   |  | Payroll  |
+----+----+  +----+-----+
     |             |
     +------+------+
            |
            v
+---------------------+
| Finalize:           |
| - Lock run          |
| - Generate PDFs     |
| - Notify employees  |
| - Log audit         |
+----------+----------+
           |
           v
+---------------------+
| End: Payroll        |
| Completed           |
+---------------------+
```

---

# 18. Permission Matrix

## 18.1 Default Roles

| Role | Level | Description |
|------|-------|-------------|
| Super Admin | System | Full system access, all modules, all actions |
| HR Manager | Department | HR operations management, approvals |
| HR Staff | Department | HR data entry, employee management |
| Manager | Team | Team management, approvals, reporting |
| Employee | Individual | Self-service access |
| Finance | Department | Payroll, financial reports |
| Viewer | Limited | Read-only access to specific modules |

## 18.2 Module Permission Matrix

| Module | Permission | Super Admin | HR Mgr | HR Staff | Mgr | Emp | Finance | Viewer |
|--------|-----------|-------------|--------|----------|-----|-----|---------|--------|
| **Dashboard** | view | X | X | X | X | X | X | X |
| **Employee** | view | X | X | X | X | - | X | X |
| | view.sensitive | X | X | - | - | - | X | - |
| | create | X | X | X | - | - | - | - |
| | update | X | X | X | - | - | - | - |
| | delete | X | X | - | - | - | - | - |
| | import | X | X | X | - | - | - | - |
| | export | X | X | X | X | - | X | X |
| **Department** | view | X | X | X | X | X | X | X |
| | create | X | X | X | - | - | - | - |
| | update | X | X | X | - | - | - | - |
| | delete | X | X | - | - | - | - | - |
| **Position** | view | X | X | X | X | X | X | X |
| | create | X | X | X | - | - | - | - |
| | update | X | X | X | - | - | - | - |
| | delete | X | X | - | - | - | - | - |
| **Attendance** | view | X | X | X | X | X | X | X |
| | view.all | X | X | X | - | - | X | - |
| | create | X | X | X | - | - | - | - |
| | update | X | X | X | - | - | - | - |
| | approve | X | X | - | X | - | - | - |
| | export | X | X | X | X | - | X | - |
| **Leave** | request | X | X | X | X | X | - | - |
| | view | X | X | X | X | X | X | X |
| | view.all | X | X | X | - | - | X | - |
| | approve | X | X | - | X | - | - | - |
| | manage.balance | X | X | X | - | - | - | - |
| **Payroll** | view.own | X | X | X | X | X | X | - |
| | view.all | X | X | X | - | - | X | - |
| | create.run | X | X | - | - | - | X | - |
| | process | X | X | - | - | - | X | - |
| | complete | X | X | - | - | - | - | - |
| | adjust | X | X | - | - | - | X | - |
| **Recruitment** | view | X | X | X | X | - | - | X |
| | create.job | X | X | X | - | - | - | - |
| | manage.candidates | X | X | X | X | - | - | - |
| | send.offer | X | X | X | - | - | - | - |
| **Performance** | view.own | X | X | X | X | X | - | - |
| | view.all | X | X | X | X | - | - | - |
| | create.cycle | X | X | X | - | - | - | - |
| | submit.review | X | X | X | X | X | - | - |
| | manage.goals | X | X | X | X | X | - | - |
| **Announcement** | view | X | X | X | X | X | X | X |
| | create | X | X | X | - | - | - | - |
| | publish | X | X | X | - | - | - | - |
| | delete | X | X | X | - | - | - | - |
| **Settings** | view | X | X | - | - | - | - | - |
| | manage.company | X | X | - | - | - | - | - |
| | manage.roles | X | X | - | - | - | - | - |
| | manage.permissions | X | X | - | - | - | - | - |
| | manage.system | X | X | - | - | - | - | - |
| **Reports** | view | X | X | X | X | - | X | X |
| | create | X | X | X | X | - | X | - |
| | export | X | X | X | X | - | X | - |
| | schedule | X | X | X | - | - | - | - |
| **Analytics** | view | X | X | X | X | - | X | - |
| **Audit Log** | view | X | X | - | - | - | - | - |
| | export | X | X | - | - | - | - | - |

## 18.3 Permission Naming Convention

```
{module}.{action}              (e.g., employee.create)
{module}.{sub_module}.{action}  (e.g., payroll.run.process)
{module}.{scope}.{action}       (e.g., leave.view.own, leave.view.all)
```

### Standard Actions

| Action | Description |
|--------|-------------|
| view | Read access |
| view.own | Read own data only |
| view.all | Read all data in module |
| view.sensitive | Read sensitive fields (salary, bank) |
| create | Create new records |
| update | Update existing records |
| delete | Soft delete records |
| delete.force | Force delete records |
| import | Bulk import data |
| export | Export data |
| approve | Approve workflow items |

## 18.4 Seed Data

```php
// Database/Seeders/RolesAndPermissionsSeeder.php
$superAdmin = Role::create(['name' => 'super-admin', 'display_name' => 'Super Admin', 'is_system' => true]);
$hrManager = Role::create(['name' => 'hr-manager', 'display_name' => 'HR Manager', 'is_system' => true]);
$hrStaff = Role::create(['name' => 'hr-staff', 'display_name' => 'HR Staff', 'is_system' => true]);
$manager = Role::create(['name' => 'manager', 'display_name' => 'Manager', 'is_system' => true]);
$employee = Role::create(['name' => 'employee', 'display_name' => 'Employee', 'is_system' => true]);
$finance = Role::create(['name' => 'finance', 'display_name' => 'Finance', 'is_system' => true]);
$viewer = Role::create(['name' => 'viewer', 'display_name' => 'Viewer', 'is_system' => true]);

// Assign permissions per matrix above...
Permission::create(['name' => 'employee.create', 'display_name' => 'Create Employees', 'module' => 'employee', 'group_name' => 'Employee Management']);
Permission::create(['name' => 'payroll.run.process', 'display_name' => 'Process Payroll', 'module' => 'payroll', 'group_name' => 'Payroll Management']);
```

---

# 19. UI Wireframe Descriptions

## 19.1 Design System

- **Framework**: Tailwind CSS + Headless UI
- **Component Library**: Custom components built on Headless UI primitives
- **Icons**: Heroicons (outline)
- **Typography**: Inter font family
- **Color Palette**:
  - Primary: Blue (#3B82F6 / #60A5FA)
  - Success: Green (#10B981 / #34D399)
  - Warning: Amber (#F59E0B / #FBBF24)
  - Danger: Red (#EF4444 / #F87171)
  - Neutral: Slate (#64748B / #94A3B8)

## 19.2 Login Page

- Clean, centered card layout
- Company logo at top
- Email and password fields with floating labels
- "Remember Me" checkbox
- "Forgot Password?" link
- Login button (full width)
- SSO login button
- 2FA verification screen (after login if enabled)
- Dark/light mode toggle in bottom corner

## 19.3 Dashboard Page

- **Header**: User avatar + name, notification bell (with badge), quick actions dropdown
- **Left Sidebar**: Collapsible navigation with module icons
- **Widget Grid**: Role-based, configurable widgets
- Employee: Clock-in button, leave balance card, today's schedule, upcoming holidays
- Manager: Team attendance summary (mini table), pending approvals list, team availability calendar
- HR: Headcount trend chart, turnover rate, recent hires, pending tasks
- Admin: Active users count, system health, queue status, storage usage

## 19.4 Employee List Page

- **Search Bar**: Global search with autocomplete
- **Filter Bar**: Department dropdown, status dropdown, employment type, date range
- **Data Table**: Sortable columns, checkbox selection, bulk actions
  - Columns: Employee ID, Name, Department, Position, Status, Hire Date, Actions
- **Pagination**: Bottom of table with page size selector
- **Actions**: View, Edit, Delete (per row); Import, Export, Add Employee (top buttons)
- **Bulk Actions**: Select all, Export selected, Change Status, Send Notification

## 19.5 Employee Detail Page

- **Profile Header**: Avatar, name, employee ID, status badge, quick actions
- **Tabbed Layout**:
  - Tab 1: Personal Info (editable fields grouped by section)
  - Tab 2: Employment Details (department, position, hire date, etc.)
  - Tab 3: Documents (upload area, file list with preview)
  - Tab 4: Payroll (salary, bank details, payslip history)
  - Tab 5: Leave (balance summary, request history)
  - Tab 6: Attendance (calendar view, monthly summary)
  - Tab 7: History (timeline of all changes made to this employee)

## 19.6 Leave Request Form

- Leave type selector (radio buttons or card select)
- Date range picker (two date inputs with calendar popup)
- Duration: Full day / Half day (morning/afternoon)
- Reason textarea
- Attachment upload (if sick leave > 3 days)
- Balance summary displayed (used/remaining for selected type)
- Submit button with confirmation dialog

## 19.7 Leave Calendar View

- Monthly calendar grid
- Color-coded by leave type
- Hover shows employee name and leave details
- Legend for leave type colors
- Month navigation (prev/next)
- "Today" button to reset to current month
- Filter by department or team

## 19.8 Payroll Run Page

- **Runs List**: Table of past payroll runs with period, status, totals
- **Create Run**: Period selector, payment date, employee count preview
- **Run Detail**: Summary at top (total gross, deductions, net, headcount)
- **Payslip List**: Table of all employees in this run with calculated values
- **Actions**: Preview, Process, Complete, Cancel (context-dependent)
- **Color Status Badges**: Draft (gray), Processing (yellow), Completed (green), Cancelled (red)

## 19.9 Payslip View

- Clean A4-styled layout for screen and PDF
- Company logo and details at top
- Employee details section
- Earnings table (component name, amount) with subtotal
- Deductions table with subtotal
- Net salary highlighted
- Attendance summary (days present, absent, leave, OT)
- Download PDF button

## 19.10 Settings Page

- **Left Sidebar**: Settings sections list
- **Company Profile**: Logo upload, company name, address, tax info
- **Roles & Permissions**: Role list → edit → permission checkboxes grouped by module
- **Users**: User list → assign roles
- **General Settings**: Timezone, date format, currency, fiscal year

## 19.11 Report Builder

- **Step 1**: Select report type (employee list, attendance, leave, payroll)
- **Step 2**: Select columns to include (checkbox list)
- **Step 3**: Set filters (field-specific filter controls)
- **Step 4**: Choose format (CSV, Excel, PDF)
- **Step 5**: Preview or generate
- **Scheduled Reports**: Frequency selector, recipients email list, next run date

## 19.12 Mobile Responsiveness

- Bottom navigation bar for mobile
- Simplified tables (card layout on mobile)
- Slide-out sidebar
- Touch-friendly button sizes (min 44px)
- Clock-in with large button

---

# 20. Development Roadmap

## 20.1 Phase 1: Foundation (Weeks 1-3)

### Sprint 1: Project Setup & Auth (Week 1)
- [ ] Initialize Laravel 12 project with Inertia + Vue 3
- [ ] Configure Tailwind CSS, Vite, TypeScript
- [ ] Set up Docker environment (nginx, php, mysql, redis)
- [ ] Configure Sanctum authentication
- [ ] Implement Login, Logout, Forgot/Reset Password
- [ ] Create User model + migration
- [ ] Set up Spatie Laravel Permission (roles, permissions)
- [ ] Create default role seeder
- [ ] Implement 2FA (TOTP)
- [ ] Write auth unit/feature tests
- **Deliverable**: Working authentication system with tests

### Sprint 2: Core Data Models (Week 2)
- [ ] Department CRUD (model, migration, controller, service, repository)
- [ ] Position CRUD
- [ ] Employee CRUD (with document upload)
- [ ] Employee search, filter, pagination
- [ ] Import/Export (CSV/Excel)
- [ ] Dashboard API with role-based widgets
- [ ] Employee timeline/history
- **Deliverable**: Employee management with full CRUD

### Sprint 3: Leave + Attendance (Week 3)
- [ ] Attendance clock-in/out API
- [ ] Attendance record management
- [ ] Work schedule configuration
- [ ] Holiday management
- [ ] Leave types CRUD
- [ ] Leave balance initialization/calculation
- [ ] Leave request CRUD
- [ ] Leave approval workflow (multi-level)
- [ ] Leave calendar API
- **Deliverable**: Attendance tracking + leave management

## 20.2 Phase 2: Core Operations (Weeks 4-6)

### Sprint 4: Payroll (Week 4-5)
- [ ] Payroll components CRUD
- [ ] Employee payroll component assignment
- [ ] Payroll run CRUD
- [ ] Payroll calculation engine (basic salary, allowances, OT)
- [ ] Tax calculation service
- [ ] Deduction calculation (social security, insurance, pension)
- [ ] Payslip generation
- [ ] Payslip PDF generation (DOM PDF)
- [ ] Payroll adjustment (bonus, penalty)
- [ ] Payroll preview before finalization
- [ ] Payroll export (journal entries)
- **Deliverable**: Complete payroll processing

### Sprint 5: Recruitment (Week 5)
- [ ] Job posting CRUD
- [ ] Recruitment stages configuration
- [ ] Candidate management
- [ ] Pipeline drag-and-drop API
- [ ] Stage transition logging
- [ ] Offer letter generation
- **Deliverable**: Recruitment pipeline

### Sprint 6: Performance (Week 6)
- [ ] Review cycles CRUD
- [ ] Performance review assignment
- [ ] Self-review submission
- [ ] Manager review submission
- [ ] Goal CRUD with KPI tracking
- [ ] Review sections with criteria rating
- **Deliverable**: Performance review system

## 20.3 Phase 3: Cross-Cutting (Weeks 7-8)

### Sprint 7: Communication (Week 7)
- [ ] Announcement CRUD with scheduling
- [ ] Targeted audience configuration
- [ ] Announcement read tracking
- [ ] In-app notifications system
- [ ] Email notification sending
- [ ] Notification preferences
- [ ] Notification templates
- **Deliverable**: Communication suite

### Sprint 8: Admin & System (Week 8)
- [ ] Company profile settings
- [ ] System settings (key-value store)
- [ ] Role management UI
- [ ] Permission management UI
- [ ] User-role assignment
- [ ] Audit log viewer with filters
- [ ] Audit log export
- [ ] Report definitions CRUD
- [ ] Report generation (sync + async)
- [ ] Report scheduling
- [ ] Analytics API endpoints
- **Deliverable**: Admin tools + reporting

## 20.4 Phase 4: Polish & Launch (Weeks 9-10)

### Sprint 9: Frontend Completion (Week 9)
- [ ] Complete all Vue pages for all modules
- [ ] Dashboard widgets implementation
- [ ] Form validation UX (inline errors)
- [ ] Loading states, empty states, error states
- [ ] Responsive layout for mobile
- [ ] Dark/light mode toggle
- [ ] Keyboard navigation
- [ ] Accessibility audit (WCAG 2.1 AA)
- **Deliverable**: Complete frontend

### Sprint 10: Testing & Deployment (Week 10)
- [ ] Unit tests > 85% coverage
- [ ] Feature tests for all CRUD operations
- [ ] API tests for all endpoints
- [ ] Load testing with K6 (critical paths)
- [ ] Security audit (OWASP Top 10)
- [ ] CI/CD pipeline setup (GitHub Actions)
- [ ] Production deployment (Docker + Kubernetes)
- [ ] Monitoring setup (Telescope, Horizon, Sentry)
- [ ] Performance optimization (caching, indexing)
- [ ] Documentation handover
- **Deliverable**: Production-ready system

## 20.5 Effort Summary

| Phase | Sprints | Duration | Story Points | Team Size |
|-------|---------|----------|--------------|-----------|
| Foundation | 3 | 3 weeks | 210 | 3-4 devs |
| Core Operations | 3 | 3 weeks | 320 | 4-5 devs |
| Cross-Cutting | 2 | 2 weeks | 180 | 3-4 devs |
| Polish & Launch | 2 | 2 weeks | 150 | 3-4 devs |
| **Total** | **10** | **10 weeks** | **860** | **3-5 devs** |

## 20.6 Team Composition

| Role | Count | Responsibility |
|------|-------|---------------|
| Senior Laravel Developer | 2 | Backend, API, Services, Architecture |
| Vue.js Developer | 1 | Frontend components, Pages |
| Full-Stack Developer | 1 | Frontend + Backend support |
| QA Engineer | 1 | Testing, Automation, CI/CD |
| DevOps Engineer (shared) | 0.5 | Deployment, Infrastructure |
| Product Manager / Tech Lead | 1 | Sprint planning, Architecture decisions |

## 20.7 Risk Register

| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| Payroll calculation complexity | High | Medium | Extensive test cases, manual verification |
| Performance with 10k+ employees | Medium | Low | Caching strategy, pagination, indexing |
| Scope creep during development | Medium | High | Strict MVP scope, change request process |
| Team availability | Medium | Medium | Knowledge sharing, documentation |
| Third-party integration delays | Low | Medium | Phase 2 planning, API-first design |
| Security vulnerability | High | Low | Regular audits, dependency updates |
