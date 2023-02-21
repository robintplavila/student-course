export const routes = [
    {
        path: '/',
        redirect: '/login'
    },
    {
        path: '/login',
        component: () => import('./views/account/login'),
        name: 'login'
    },
    {
        path: '/users',
        name: 'users',
        component: () => import('./views/users/index'),
        meta: {
            auth: true
        }

    },
    {
        path: '/new-user',
        name: 'new-user',
        component: () => import('./views/users/users'),
        // meta: {
        //     auth: true
        // }

    },
    {
        path: '/edit-user/:id',
        name: 'edit-user',
        component: () => import('./views/users/users'),
        // meta: {
        //     auth: true
        // }

    } ,
    {
        path: '/roles',
        name: 'user_roles',
        component: () => import('./views/user_roles/index'),
        // meta: {
        //     auth: true
        // }

    },
    {
        path: '/new-role',
        name: 'new-user-role',
        component: () => import('./views/user_roles/roles'),
        // meta: {
        //     auth: true
        // }

    },
    {
        path: '/edit-role/:id',
        name: 'edit-user-role',
        component: () => import('./views/user_roles/roles'),
        // meta: {
        //     auth: true
        // }

    },  
    {
        path: '/students',
        name: 'students',
        component: () => import('./views/students/index'),
        meta: {
            auth: true
        }

    },
    {
        path: '/new-student',
        name: 'new-student',
        component: () => import('./views/students/users'),
        // meta: {
        //     auth: true
        // }

    },
    {
        path: '/edit-student/:id',
        name: 'edit-student',
        component: () => import('./views/students/users'),
        // meta: {
        //     auth: true
        // }

    } ,
    {
        path: '/courses',
        name: 'courses',
        component: () => import('./views/courses/index'),
        // meta: {
        //     auth: true
        // }

    },
    {
        path: '/new-course',
        name: 'new-course',
        component: () => import('./views/courses/courses'),
        // meta: {
        //     auth: true
        // }

    },
    {
        path: '/edit-course/:id',
        name: 'edit-course',
        component: () => import('./views/courses/courses'),
        // meta: {
        //     auth: true
        // }

    } ,

    {
        path: '/results',
        name: 'results',
        component: () => import('./views/results/index'),
        // meta: {
        //     auth: true
        // }

    },
    {
        path: '/new-result',
        name: 'new-result',
        component: () => import('./views/results/results'),
        // meta: {
        //     auth: true
        // }

    },
    {
        path: '/edit-result/:id',
        name: 'edit-result',
        component: () => import('./views/results/results'),
        // meta: {
        //     auth: true
        // }

    } ,
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import('./views/dashboard/index'),
        // meta: {
        //     auth: true
        // }

    },

]
