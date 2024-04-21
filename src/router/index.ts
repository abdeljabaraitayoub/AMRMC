import { createRouter, createWebHistory } from 'vue-router'

import SigninView from '@/views/Authentication/SigninView.vue'
import SignupView from '@/views/Authentication/SignupView.vue'
import CalendarView from '@/views/CalendarView.vue'
import BasicChartView from '@/views/Charts/BasicChartView.vue'
import FormElementsView from '@/views/Forms/FormElementsView.vue'
import FormLayoutView from '@/views/Forms/FormLayoutView.vue'
import SettingsView from '@/views/Pages/SettingsView.vue'
import ProfileView from '@/views/ProfileView.vue'
import TablesView from '@/views/TablesView.vue'
import AlertsView from '@/views/UiElements/AlertsView.vue'
import ButtonsView from '@/views/UiElements/ButtonsView.vue'

//admin route
import UsersView from '@/views/Admin/UsersView.vue'
import activities from '@/views/Admin/ActivitiesView.vue'
import AssociationsView from '@/views/Admin/AssociationsView.vue'
import DiseaseView from '@/views/Admin/DiseaseView.vue'
import MedicsView from '@/views/Admin/MedicsView.vue'
import BackupView from '@/views/Admin/BackupView.vue'
import DashboardView from '@/views/Admin/DashboardView.vue'

//association route
import PatientView from '@/views/Association/PatientView.vue'
import AgentsView from '@/views/Association/AgentsView.vue'
import AssociationSettingsView from '@/views/Association/SettingsView.vue'
import AssociationActivitiesView from '@/views/Association/ActivitiesView.vue'


const routes = [
  {
    path: '/calendar',
    name: 'calendar',
    component: CalendarView,
    meta: {
      title: 'Calendar'
    }
  },
  {
    path: '/profile',
    name: 'profile',
    component: ProfileView,
    meta: {
      title: 'Profile'
    }
  },
  {
    path: '/forms/form-elements',
    name: 'formElements',
    component: FormElementsView,
    meta: {
      title: 'Form Elements'
    }
  },
  {
    path: '/forms/form-layout',
    name: 'formLayout',
    component: FormLayoutView,
    meta: {
      title: 'Form Layout'
    }
  },
  {
    path: '/tables',
    name: 'tables',
    component: TablesView,
    meta: {
      title: 'Tables'
    }
  },
  {
    path: '/settings',
    name: 'settings',
    component: SettingsView,
    meta: {
      title: 'Settings'
    }
  },
  {
    path: '/charts/basic-chart',
    name: 'basicChart',
    component: BasicChartView,
    meta: {
      title: 'Basic Chart'
    }
  },
  {
    path: '/ui-elements/alerts',
    name: 'alerts',
    component: AlertsView,
    meta: {
      title: 'Alerts'
    }
  },
  {
    path: '/ui-elements/buttons',
    name: 'buttons',
    component: ButtonsView,
    meta: {
      title: 'Buttons'
    }
  },
  {
    path: '/signin',
    name: 'signin',
    component: SigninView,
    meta: {
      title: 'Signin'
    }
  },
  {
    path: '/signup',
    name: 'signup',
    component: SignupView,
    meta: {
      title: 'Signup'
    }
  },
  //admin route
  {
    path: '/users',
    name: 'UsersView',
    component: UsersView,
    meta: {
      title: 'Users'
    }
  },
  {
    path: '/association',
    name: 'AssociationsView',
    component: AssociationsView,
    meta: {
      title: 'Associations'
    }
  },
  {
    path: '/activities',
    name: 'activities',
    component: activities,
    meta: {
      title: 'activities'
    }
  },
  {
    path: '/disease',
    name: 'DiseaseView',
    component: DiseaseView,
    meta: {
      title: 'Disease'
    }
  }
  ,
  {
    path: '/medics',
    name: 'Medics',
    component: MedicsView,
    meta: {
      title: 'Medics'
    }
  } ,
  {
    path: '/backups',
    name: 'backups',
    component: BackupView,
    meta: {
      title: 'backups'
    }
  },
  {
    path: '/',
    name: 'Dashboard',
    component: DashboardView,
    meta: {
      title: 'Dashboard'
    }
  }

  //association route
  ,
  {
    path: '/patients',
    name: 'PatientView',
    component: PatientView,
    meta: {
      title: 'Patients'
    }
  },
  {
    path: '/agents',
    name: 'AgentsView',
    component: AgentsView,
    meta: {
      title: 'Association | Agents'
    }
  },
  {
    path: '/association/settings',
    name: 'SettingsView',
    component: AssociationSettingsView,
    meta: {
      title: 'Association | Settings'
    }
  }
  ,
  {
    path: '/association/activities',
    name: 'ActivitiesView',
    component: AssociationActivitiesView,
    meta: {
      title: 'Association | Activities'
    }
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { left: 0, top: 0 }
  }
})

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} | AMRMC`
  next()
})

export default router
