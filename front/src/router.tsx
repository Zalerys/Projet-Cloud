import { createBrowserRouter } from 'react-router-dom';

// ROOT
import Root from './layouts/Root';
// AUTH
import Auth from './layouts/Auth';
import AuthMethod from './components/Auth/AuthMethod/AuthMethod';
import EmailAuth from './components/Auth/EmailAuth/EmailAuth';
import Logout from './components/Auth/Logout';
import ForgotPassword from './components/Auth/ForgotPassword';
// DASHBOARD
import Dashboard from './layouts/Dashboard';
// HELPERS
import ErrorPage from './layouts/ErrorPage';
import Redirect from './components/Helpers/Redirect';
import Projects from './components/Dashboard/Projects/Projects';
import ProjectsList from './components/Dashboard/Projects/ProjectsList';
import ProjectDetails from './components/Dashboard/Projects/ProjectDetails';



const router = createBrowserRouter([
  {
    path: '/',
    element: <Root />,
    errorElement: <ErrorPage />,
  },
  {
    path: '/auth',
    element: <Auth />,
    errorElement: <ErrorPage />,
    children: [
      // ['/', 'register', 'login'].map((path) => { path, element: <EmailAuth switchAuthModeHandler={null} /> }),
      {
        index: true,
        element: <AuthMethod />,
      },
      {
        path: 'register',
        element: <EmailAuth action="register" />,
      },
      {
        path: 'login',
        element: <EmailAuth action="login" />,
      },
      {
        path: 'logout',
        element: <Logout />,
      },
      {
        path: 'forgot-password',
        element: <ForgotPassword />,
      },
    ],
  },
  {
    path: '/dashboard',
    element: <Dashboard />,
    errorElement: <ErrorPage />,
    children: [
      {
        index: true,
        element: <Redirect to="/dashboard/projects" />,
      },
      {
        path: 'projects',
        element: <Projects />,
        children: [
          {
            index: true,
            element: <ProjectsList />
          },
          {
            path: 'create',
            element: <CreateProject />
          },
          {
            path: ':projectId',
            element: <ProjectDetails />
          },
          {
            path: ':projectId/edit',
            element: <EditProject />
          },
          {
            path: ':projectId/delete',
            element: <DeleteProject />
          },
        ],
      }
    ]
  }
]);

export default router;
