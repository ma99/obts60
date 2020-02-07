export const routes = [
    {
        path: '/dashboard',
        component: require('./views/Home').default
    },

    {
        //path: '/about',
        path: '/about',
        component: require('./views/About').default
    },

    {
        path: '/contact',
        component: require('./views/Contact').default
    },
    {
        path: '/staff-management',
        component: require('./views/StaffManagement').default
    },
    //User
    {
        path: '/profile',
        component: require('./views/Profile').default
    },
    {
        path: '/roles',
        component: require('./views/Roles').default
    },
    {
        path: '/staff-list',
        component: require('./views/StaffList').default
    },
    //Bus 
    {
        path: '/bus',
        component: require('./views/bus/Bus').default
    },
    {
        path: '/list',
        component: require('./views/bus/BusList').default
    },
    {
        path: '/route',
        component: require('./views/bus/Route').default
    },
    {
        path: '/seat-plan',
        component: require('./views/bus/SeatPlan').default
    },
    {
        path: '/fare',
        component: require('./views/bus/Fare').default
    },
    {
        path: '/schedule',
        component: require('./views/bus/Schedule').default
    },
    {
        path: '/city',
        component: require('./views/city/City').default
    },
    {
        path: '/stop',
        component: require('./views/city/Stop').default
    },
    //404
    {   
        path: '*',
        //component: fourohfour
        component: require('./views/Fourohfour').default
    },
];