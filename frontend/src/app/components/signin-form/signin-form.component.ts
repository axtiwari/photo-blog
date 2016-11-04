import {Component, Inject} from '@angular/core';
import {SignInForm} from './signin-form';
import {AuthService} from '../../../shared/services/auth/auth.service';
import {NavigatorService, NavigatorServiceProvider} from '../../../shared/services/navigator';

@Component({
    selector: 'signin-form',
    template: require('./signin-form.component.html'),
})
export class SignInFormComponent {
    private navigatorService:NavigatorService;
    private form:SignInForm;

    constructor(@Inject(AuthService) private authService:AuthService,
                @Inject(NavigatorServiceProvider) private navigatorServiceProvider:NavigatorServiceProvider) {
        this.navigatorService = this.navigatorServiceProvider.getInstance();
    }

    ngOnInit() {
        this.form = new SignInForm;
    }

    signIn() {
        this.authService.signIn(this.form.email, this.form.password).then((user:any) => {
            this.navigatorService.navigate(['/']);
        });
    }
}
