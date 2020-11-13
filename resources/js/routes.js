
import Bookables from "../js/bookables/Bookables";
import Bookable from "../js/bookable/Bookable";
import ToccaVinoHome from "../js/toccavino/ToccaVinoHome";
import ToccaVinoAddEvent from "../js/toccavino/ToccaVinoAddEvent";
import ToccaVinoPayment from "../js/toccavino/ToccaVinoPayment";
import Register from "../js/auth/Register";
import VerifyEmail from "../js/auth/VerifyEmail";
import ForgotPassword from "../js/auth/ForgotPassword";
import ResetPassword from "../js/auth/ResetPassword";
import AdminDashboard from "../js/admin/AdminDashboard";
import UserProfile from "../js/user/UserProfile";
import Portfolio from "../js/portfolio/Portfolio";
import Projects from "../js/portfolio/Projects";
import SingleProject from "../js/portfolio/SingleProject";







import Review from "../js/review/Review";
import Basket from "../js/basket/Basket";
import NotFound from "../js/shared/components/NotFound";


import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: Portfolio,
        name: "home"
    },
    {
        path: "/laravelBnB",
        component: Bookables,
        name: "laravelBnB"
    },
    {
        path: "/projects",
        component: Projects,
        name: "projects"
    },
    {
        path: "/project/:id",
        component: SingleProject,
        name: "project"
    },
    // un altro modo alternativo per importare un componente vue
    {
        path: "/auth/login",
        component: require('./auth/Login.vue').default,
        name: "login"
    },
    {
        path: "/adminDashboard",
        component: AdminDashboard,
        name: "adminDashboard"
    },
    {
        path: "/userProfile",
        component: UserProfile,
        name: "userProfile"
    },
    {
        path: "/auth/register",
        component: Register,
        name: "register"
    },
    {
        path: "/verify-email",
        component: VerifyEmail,
        name: "verifyEmail"
    },
    {
        path: "/forgot-password",
        component: ForgotPassword,
        name: "forgotPassword"
    },
    {
        path: "/reset-password",
        component: ResetPassword,
        name: "resetPassword"
    },
    {
        path: "/bookable/:id",
        component: Bookable,
        name: "bookable"
    },
    {
        path: "/reviews/:id",
        component: Review,
        name: "review"
    },
    {
        path: "/basket",
        component: Basket,
        name: "basket"
    },
    {
        path: "/tocca-vino",
        component: ToccaVinoHome,
        name: "toccaVinoHome"
    },
    {
        path: "/add-wine-event",
        component: ToccaVinoAddEvent,
        name: "toccaVinoAddEvent"
    },
    {
        path: "/support-us",
        component: ToccaVinoPayment,
        name: "toccaVinoPayment"
    },
    { path: '*', component: NotFound }

]

const router = new VueRouter({
    mode: 'history',
    routes,
})

export default router;
