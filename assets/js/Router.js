import BaseRouter from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js'

const routes = require('../../public/js/fos_js_routes.json');
BaseRouter.setRoutingData(routes);

class Router {
    static generate (routeName, params = {}) {
        params._locale = document.getElementsByTagName('html')[0].getAttribute('lang');

        return BaseRouter.generate(routeName, params)
    }
}

export {Router as default}
