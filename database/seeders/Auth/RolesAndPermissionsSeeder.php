<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = [
            'dashboard' => ['view'],
            'employee' => ['view', 'view.sensitive', 'create', 'update', 'delete', 'import', 'export'],
            'department' => ['view', 'create', 'update', 'delete'],
            'position' => ['view', 'create', 'update', 'delete'],
            'attendance' => ['view', 'view.all', 'create', 'update', 'approve', 'export'],
            'leave' => ['request', 'view', 'view.all', 'approve', 'manage.balance'],
            'payroll' => ['view.own', 'view.all', 'create.run', 'process', 'complete', 'adjust'],
            'recruitment' => ['view', 'create.job', 'manage.candidates', 'send.offer'],
            'performance' => ['view.own', 'view.all', 'create.cycle', 'submit.review', 'manage.goals'],
            'announcement' => ['view', 'create', 'publish', 'delete'],
            'settings' => ['view', 'manage.company', 'manage.roles', 'manage.permissions', 'manage.system'],
            'reports' => ['view', 'create', 'export', 'schedule'],
            'analytics' => ['view'],
            'audit' => ['view', 'export'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::findOrCreate("{$module}.{$action}", 'web');
            }
        }

        $roles = [
            'super-admin' => ['display_name' => 'Super Admin', 'is_system' => true, 'permissions' => Permission::pluck('name')->toArray()],
            'hr-manager' => ['display_name' => 'HR Manager', 'is_system' => true, 'permissions' => $this->getHrManagerPermissions()],
            'hr-staff' => ['display_name' => 'HR Staff', 'is_system' => true, 'permissions' => $this->getHrStaffPermissions()],
            'manager' => ['display_name' => 'Manager', 'is_system' => true, 'permissions' => $this->getManagerPermissions()],
            'employee' => ['display_name' => 'Employee', 'is_system' => true, 'permissions' => $this->getEmployeePermissions()],
            'finance' => ['display_name' => 'Finance', 'is_system' => true, 'permissions' => $this->getFinancePermissions()],
            'viewer' => ['display_name' => 'Viewer', 'is_system' => true, 'permissions' => $this->getViewerPermissions()],
        ];

        foreach ($roles as $name => $config) {
            $role = Role::findOrCreate($name, 'web');
            $role->update([
                'display_name' => $config['display_name'],
                'is_system' => $config['is_system'],
            ]);
            $role->syncPermissions($config['permissions']);
        }

        $this->command->info('Roles and permissions seeded successfully.');
    }

    private function getHrManagerPermissions(): array
    {
        return [
            'dashboard.view',
            'employee.view', 'employee.view.sensitive', 'employee.create', 'employee.update', 'employee.delete', 'employee.import', 'employee.export',
            'department.view', 'department.create', 'department.update', 'department.delete',
            'position.view', 'position.create', 'position.update', 'position.delete',
            'attendance.view', 'attendance.view.all', 'attendance.create', 'attendance.update', 'attendance.approve', 'attendance.export',
            'leave.request', 'leave.view', 'leave.view.all', 'leave.approve', 'leave.manage.balance',
            'payroll.view.own', 'payroll.view.all', 'payroll.create.run', 'payroll.process', 'payroll.adjust',
            'recruitment.view', 'recruitment.create.job', 'recruitment.manage.candidates', 'recruitment.send.offer',
            'performance.view.own', 'performance.view.all', 'performance.create.cycle', 'performance.submit.review', 'performance.manage.goals',
            'announcement.view', 'announcement.create', 'announcement.publish', 'announcement.delete',
            'settings.view', 'settings.manage.company',
            'reports.view', 'reports.create', 'reports.export', 'reports.schedule',
            'analytics.view',
            'audit.view', 'audit.export',
        ];
    }

    private function getHrStaffPermissions(): array
    {
        return [
            'dashboard.view',
            'employee.view', 'employee.create', 'employee.update', 'employee.import', 'employee.export',
            'department.view', 'department.create', 'department.update',
            'position.view', 'position.create', 'position.update',
            'attendance.view', 'attendance.view.all', 'attendance.create', 'attendance.update', 'attendance.export',
            'leave.request', 'leave.view', 'leave.view.all', 'leave.manage.balance',
            'payroll.view.own', 'payroll.view.all',
            'recruitment.view', 'recruitment.create.job', 'recruitment.manage.candidates',
            'performance.view.own', 'performance.view.all', 'performance.submit.review', 'performance.manage.goals',
            'announcement.view', 'announcement.create', 'announcement.publish',
            'reports.view', 'reports.create', 'reports.export',
            'analytics.view',
        ];
    }

    private function getManagerPermissions(): array
    {
        return [
            'dashboard.view',
            'employee.view', 'employee.export',
            'department.view',
            'position.view',
            'attendance.view', 'attendance.view.all', 'attendance.approve', 'attendance.export',
            'leave.request', 'leave.view', 'leave.view.all', 'leave.approve',
            'payroll.view.own',
            'recruitment.view', 'recruitment.manage.candidates',
            'performance.view.own', 'performance.view.all', 'performance.submit.review', 'performance.manage.goals',
            'announcement.view',
            'reports.view', 'reports.create', 'reports.export',
            'analytics.view',
        ];
    }

    private function getEmployeePermissions(): array
    {
        return [
            'dashboard.view',
            'leave.request', 'leave.view',
            'attendance.view',
            'payroll.view.own',
            'performance.view.own', 'performance.submit.review', 'performance.manage.goals',
            'announcement.view',
        ];
    }

    private function getFinancePermissions(): array
    {
        return [
            'dashboard.view',
            'employee.view', 'employee.view.sensitive', 'employee.export',
            'department.view',
            'position.view',
            'attendance.view', 'attendance.view.all', 'attendance.export',
            'leave.view', 'leave.view.all',
            'payroll.view.own', 'payroll.view.all', 'payroll.create.run', 'payroll.process', 'payroll.adjust',
            'performance.view.own',
            'announcement.view',
            'reports.view', 'reports.create', 'reports.export',
            'analytics.view',
        ];
    }

    private function getViewerPermissions(): array
    {
        return [
            'dashboard.view',
            'employee.view', 'employee.export',
            'department.view',
            'position.view',
            'attendance.view',
            'leave.view',
            'payroll.view.own',
            'recruitment.view',
            'announcement.view',
            'reports.view',
        ];
    }
}
