// import pharmacy from './pharmacy'; import your new routes
let routes = [
    {
        path: '/',
        name: 'login',
        component: () => import('../components/auth/login.vue'),
        meta: {
            title: 'Login',
            isGuest: true
        }
    },
    {
        path: '/forgot-password',
        name: 'forgotPassword',
        component: () => import('../components/auth/forgot-password.vue'),
        meta: {
            title: 'Forgot Password',
            isGuest: true
        }
    },
    {
        path: '/reset-password',
        name: 'resetPassword',
        component: () => import('../components/auth/reset-password.vue'),
        meta: {
            title: 'Reset Password',
            isGuest: true
        }
    },
    {
        path: '/user-verification',
        name: 'verifyotp',
        component: () => import('../components/auth/verifyotp.vue'),
        meta: {
            title: 'Verify OTP',
            isGuest: true
        }
    },
    {
        path: '/dashboard',
        name: 'app',
        // redirect: {name: 'dashboard'},
        component: () => import('../pages/app.vue'),
        meta: {
            title: 'AppLayout',
            requiresAuth: true
        },
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                component: () => import('../components/dashboard/dashboard.vue'),
                meta: {
                    title: 'Dashboard',
                    requiresAuth: true
                }
            },
            {
                path: '/user/profile',
                name: 'profile',
                component: () => import('../components/profile/edit.vue'),
                meta: {
                    title: 'Account Settings',
                    requiresAuth: true,
                    ignore: true
                }
            },
            {
                path: '/user/activity-logs',
                name: 'user.logs',
                component: () => import('../components/user/activitylog.vue'),
                meta: {
                    title: 'Activity Logs',
                    requiresAuth: true,
                    ignore: true
                }
            },

            {
                path: '/roles',
                name: 'role.index',
                component: () => import('../components/rbac/role/index.vue'),
                meta: {
                    title: 'Roles',
                    requiresAuth: true
                }
            },
            {
                path: '/roles/create',
                name: 'role.create',
                component: () => import('../components/rbac/role/create.vue'),
                meta: {
                    title: 'Create Role',
                    requiresAuth: true
                }
            },
            {
                path: '/roles/:id/edit',
                name: 'role.edit',
                component: () => import('../components/rbac/role/edit.vue'),
                meta: {
                    title: 'Edit Role',
                    requiresAuth: true
                }
            },
            {
                path: '/roles/:id/assign-permission',
                name: 'role.assign-permission',
                component: () => import('../components/rbac/role/assign-permission.vue'),
                meta: {
                    title: 'Assign Role Permission',
                    requiresAuth: true
                }
            },
            
            {
                path: '/user',
                name: 'user.index',
                component: () => import('../components/user/index.vue'),
                meta: {
                    title: 'User List',
                    requiresAuth: true
                }
            },
            {
                path: '/user/create',
                name: 'user.create',
                component: () => import('../components/user/create.vue'),
                meta: {
                    title: 'Create User',
                    requiresAuth: true
                }
            },
            {
                path: '/user/:id/edit',
                name: 'user.edit',
                component: () => import('../components/user/edit.vue'),
                meta: {
                    title: 'Edit User',
                    requiresAuth: true
                }
            },
            //settings
            // languages
            {
                path: '/settings/languages',
                name: 'language.index',
                component: () => import('../components/settings/languages/index.vue'),
                meta: {
                    title: 'Site language',
                    requiresAuth: true,
                    ignore:true,
                }
            },
            {
                path: '/settings/language/tanslate/:code',
                name: 'language.translate',
                component: () => import('../components/settings/languages/translate.vue'),
                meta: {
                    title: 'Translate Language',
                    requiresAuth: true,
                    ignore:true,
                }
            },
            {
                path: '/settings/app-info',
                name: 'appseting.index',
                component: () => import('../components/settings/appsettings/index.vue'),
                meta: {
                    title: 'Site language',
                    requiresAuth: true,
                    ignore:true,
                }
            },
            // ...pharmacy declear the file here
        ]
    },
];
export default routes;
