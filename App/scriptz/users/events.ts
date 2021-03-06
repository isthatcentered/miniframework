import { AppEvent } from '../AppEvent'

const USERS_EVENTS = {
	REGISTER: new AppEvent( 'USER_REGISTER' ),
	LOG: new AppEvent( 'USER_LOG' ),
	LOGOUT: new AppEvent( 'USER_LOGOUT' ),
	DELETE: new AppEvent( 'USER_DELETE' ),
}
export { USERS_EVENTS }