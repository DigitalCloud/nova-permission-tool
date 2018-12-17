Nova.booting((Vue, router) => {

    Vue.component('index-role', require('./components/fields/role/IndexField'));
    Vue.component('detail-role', require('./components/fields/role/DetailField'));
    Vue.component('form-role', require('./components/fields/role/FormField'));

    Vue.component('index-permission', require('./components/fields/permission/IndexField'));
    Vue.component('detail-permission', require('./components/fields/permission/DetailField'));
    Vue.component('form-permission', require('./components/fields/permission/FormField'));

    router.addRoutes([
        {
            name: 'PermissionTool',
            path: '/PermissionTool',
            component: require('./components/Tool'),
        },
    ])
})
