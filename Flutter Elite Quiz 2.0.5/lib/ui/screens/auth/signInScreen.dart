import 'dart:io';
import 'package:flutter/cupertino.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:flutterquiz/app/appLocalization.dart';
import 'package:flutterquiz/app/routes.dart';
import 'package:flutterquiz/features/auth/authRemoteDataSource.dart';
import 'package:flutterquiz/features/auth/authRepository.dart';
import 'package:flutterquiz/features/auth/cubits/authCubit.dart';
import 'package:flutterquiz/features/auth/cubits/signInCubit.dart';
import 'package:flutterquiz/features/profileManagement/cubits/userDetailsCubit.dart';
import 'package:flutterquiz/ui/screens/auth/widgets/termsAndCondition.dart';
import 'package:flutterquiz/ui/widgets/circularProgressContainner.dart';
import 'package:flutterquiz/ui/widgets/customRoundedButton.dart';
import 'package:flutterquiz/utils/errorMessageKeys.dart';
import 'package:flutterquiz/utils/uiUtils.dart';
import 'package:flutterquiz/utils/validators.dart';

class SignInScreen extends StatefulWidget {
  @override
  SignInScreenState createState() => SignInScreenState();
}

class SignInScreenState extends State<SignInScreen> {
  final _formKey = GlobalKey<FormState>();
  final _formKeyDialog = GlobalKey<FormState>();
  bool _obscureText = true, isLoading = false;
  TextEditingController edtEmail = TextEditingController();
  TextEditingController edtEmailReset = TextEditingController();
  TextEditingController edtPwd = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return BlocProvider<SignInCubit>(
      create: (_) => SignInCubit(AuthRepository()),
      child: Builder(
        builder: (context) => Scaffold(
          body: Stack(
            children: <Widget>[
              SingleChildScrollView(
                child: showForm(context),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget showForm(BuildContext context) {
    return Form(
      key: _formKey,
      child: Padding(
        padding: EdgeInsetsDirectional.only(
            start: MediaQuery.of(context).size.width * .08,
            end: MediaQuery.of(context).size.width * .08),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            SizedBox(
              height: MediaQuery.of(context).size.height * .07,
            ),
            signUpText(),
            showTopImage(),
            loginWith(),
            showSocialMedia(context),
            orLabel(),
            showEmail(),
            SizedBox(
              height: MediaQuery.of(context).size.height * .02,
            ),
            showPwd(),
            forgetPwd(),
            SizedBox(
              height: MediaQuery.of(context).size.height * 0.01,
            ),
            showSignIn(context),
            showGoSignup(),
            TermsAndCondition(),
          ],
        ),
      ),
    );
  }

  Widget signUpText() {
    return Text(
      AppLocalization.of(context)!.getTranslatedValues("userLoginLbl")!,
      style: TextStyle(
          color: Theme.of(context).primaryColor,
          fontSize: 22,
          fontWeight: FontWeight.bold),
    );
  }

  Widget showTopImage() {
    return SizedBox(
      height: 200,
      width: 200,
      child: SvgPicture.asset(
        UiUtils.getImagePath("splash_logo.svg"),
        color: Theme.of(context).primaryColor,
      ),
    );
  }

  Widget showEmail() {
    return TextFormField(
      controller: edtEmail,
      keyboardType: TextInputType.emailAddress,
      validator: (val) => Validators.validateEmail(
          val!,
          AppLocalization.of(context)!.getTranslatedValues('emailRequiredMsg')!,
          AppLocalization.of(context)!.getTranslatedValues('VALID_EMAIL')),
      style: TextStyle(color: Theme.of(context).colorScheme.secondary),
      decoration: InputDecoration(
          fillColor: Theme.of(context).backgroundColor,
          filled: true,
          border: InputBorder.none,
          hintText:
              AppLocalization.of(context)!.getTranslatedValues('emailLbl')! +
                  "*",
          hintStyle: TextStyle(
              color: Theme.of(context).colorScheme.secondary.withOpacity(0.6)),
          contentPadding: EdgeInsets.all(15),
          focusedBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(10.0),
            borderSide: new BorderSide(
              color: Theme.of(context).backgroundColor,
            ),
          ),
          enabledBorder: UnderlineInputBorder(
            borderRadius: BorderRadius.circular(10.0),
            borderSide: new BorderSide(
              color: Theme.of(context).backgroundColor,
            ),
          ),
          errorBorder: UnderlineInputBorder(
            borderRadius: BorderRadius.circular(10.0),
            borderSide: new BorderSide(
              color: Theme.of(context).backgroundColor,
            ),
          ),
          focusedErrorBorder: UnderlineInputBorder(
            borderRadius: BorderRadius.circular(10.0),
            borderSide: new BorderSide(
              color: Theme.of(context).backgroundColor,
            ),
          )),
    );
  }

  Widget showPwd() {
    return TextFormField(
      controller: edtPwd,
      style: TextStyle(color: Theme.of(context).colorScheme.secondary),
      obscureText: _obscureText,
      obscuringCharacter: "*",
      validator: (val) => val!.isEmpty
          ? '${AppLocalization.of(context)!.getTranslatedValues('pwdLengthMsg')}'
          : null,
      decoration: InputDecoration(
        fillColor: Theme.of(context).backgroundColor,
        filled: true,
        border: InputBorder.none,
        contentPadding: EdgeInsets.all(15),
        hintText:
            AppLocalization.of(context)!.getTranslatedValues('pwdLbl')! + "*",
        hintStyle: TextStyle(
            color: Theme.of(context).colorScheme.secondary.withOpacity(0.6)),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10.0),
          borderSide: new BorderSide(
            color: Theme.of(context).backgroundColor,
          ),
        ),
        enabledBorder: UnderlineInputBorder(
          borderRadius: BorderRadius.circular(10.0),
          borderSide: new BorderSide(
            color: Theme.of(context).backgroundColor,
          ),
        ),
        focusedErrorBorder: UnderlineInputBorder(
          borderRadius: BorderRadius.circular(10.0),
          borderSide: new BorderSide(
            color: Theme.of(context).backgroundColor,
          ),
        ),
        errorBorder: UnderlineInputBorder(
          borderRadius: BorderRadius.circular(10.0),
          borderSide: new BorderSide(
            color: Theme.of(context).backgroundColor,
          ),
        ),
        suffixIcon: GestureDetector(
          child: Icon(
            _obscureText ? Icons.visibility : Icons.visibility_off,
            color: Theme.of(context).colorScheme.secondary.withOpacity(0.6),
          ),
          onTap: () {
            setState(() {
              _obscureText = !_obscureText;
            });
          },
        ),
      ),
    );
  }

  Widget showSignIn(BuildContext context) {
    return Container(
      width: MediaQuery.of(context).size.width * 0.6,
      height: MediaQuery.of(context).size.height * 0.055,
      child: BlocConsumer<SignInCubit, SignInState>(
        bloc: context.read<SignInCubit>(),
        listener: (context, state) async {
          //Exceuting only if authProvider is email
          if (state is SignInSuccess &&
              state.authProvider == AuthProvider.email) {
            //to update authdetails after successfull sign in
            context.read<AuthCubit>().updateAuthDetails(
                authProvider: state.authProvider,
                firebaseId: state.user.uid,
                authStatus: true,
                isNewUser: state.isNewUser);
            if (state.isNewUser) {
              context.read<UserDetailsCubit>().fetchUserDetails(state.user.uid);
              //navigate to select profile screen

              Navigator.of(context)
                  .pushReplacementNamed(Routes.selectProfile, arguments: true);
            } else {
              //get user detials of signed in user
              context.read<UserDetailsCubit>().fetchUserDetails(state.user.uid);
              Navigator.of(context)
                  .pushReplacementNamed(Routes.home, arguments: false);
            }
          } else if (state is SignInFailure &&
              state.authProvider == AuthProvider.email) {
            UiUtils.setSnackbar(
                AppLocalization.of(context)!.getTranslatedValues(
                    convertErrorCodeToLanguageKey(state.errorMessage))!,
                context,
                false);
          }
        },
        builder: (context, state) {
          return CupertinoButton(
            padding: EdgeInsets.all(5),
            child: state is SignInProgress &&
                    state.authProvider == AuthProvider.email
                ? Center(
                    child: CircularProgressContainer(
                    heightAndWidth: 40,
                    useWhiteLoader: true,
                  ))
                : Text(
                    AppLocalization.of(context)!
                        .getTranslatedValues('loginLbl')!,
                    style: TextStyle(color: Theme.of(context).backgroundColor),
                  ),
            color: Theme.of(context).primaryColor,
            onPressed: state is SignInProgress
                ? () {}
                : () async {
                    if (_formKey.currentState!.validate()) {
                      {
                        context.read<SignInCubit>().signInUser(
                            AuthProvider.email,
                            email: edtEmail.text.trim(),
                            password: edtPwd.text.trim());
                      }
                    }
                  },
          );
        },
      ),
    );
  }

  Widget showEmailForForgotPwd() {
    return TextFormField(
        controller: edtEmailReset,
        keyboardType: TextInputType.emailAddress,
        validator: (val) => Validators.validateEmail(
            val!,
            AppLocalization.of(context)!
                .getTranslatedValues('emailRequiredMsg')!,
            AppLocalization.of(context)!.getTranslatedValues('validEmail')),
        onSaved: (value) => edtEmailReset.text = value!.trim(),
        style: TextStyle(color: Theme.of(context).colorScheme.secondary),
        decoration: InputDecoration(
            fillColor: Theme.of(context).primaryColor.withOpacity(0.2),
            filled: true,
            border: InputBorder.none,
            hintText: AppLocalization.of(context)!
                .getTranslatedValues('enterEmailLbl')!,
            hintStyle: TextStyle(
                color:
                    Theme.of(context).colorScheme.secondary.withOpacity(0.5)),
            contentPadding: EdgeInsets.all(15),
            focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(10.0),
              borderSide: BorderSide.none,
            ),
            enabledBorder: UnderlineInputBorder(
              borderRadius: BorderRadius.circular(10.0),
              borderSide: new BorderSide(color: Colors.white),
            ),
            errorBorder: UnderlineInputBorder(
              borderRadius: BorderRadius.circular(10.0),
              borderSide: new BorderSide(
                color: Theme.of(context).backgroundColor,
              ),
            ),
            focusedErrorBorder: UnderlineInputBorder(
              borderRadius: BorderRadius.circular(10.0),
              borderSide: new BorderSide(
                color: Theme.of(context).backgroundColor,
              ),
            )));
  }

  forgetPwd() {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: Align(
        alignment: Alignment.bottomRight,
        child: InkWell(
            splashColor: Colors.white,
            child: Text(
                AppLocalization.of(context)!
                    .getTranslatedValues('forgotPwdLbl')!,
                style: TextStyle(
                    fontSize: 12, color: Theme.of(context).primaryColor)),
            onTap: () async {
              showModalBottomSheet(
                  isScrollControlled: true,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.only(
                        topLeft: Radius.circular(20.0),
                        topRight: Radius.circular(20.0)),
                  ),
                  context: context,
                  builder: (context) => Padding(
                      padding: MediaQuery.of(context).viewInsets,
                      child: Container(
                        decoration: BoxDecoration(
                            color: Theme.of(context).backgroundColor,
                            borderRadius: BorderRadius.only(
                                topLeft: Radius.circular(20),
                                topRight: Radius.circular(20))),
                        constraints: BoxConstraints(
                            maxHeight:
                                MediaQuery.of(context).size.height * (0.4)),
                        child: Form(
                          key: _formKeyDialog,
                          child: Column(
                            children: [
                              SizedBox(
                                height:
                                    MediaQuery.of(context).size.height * 0.03,
                              ),
                              Text(
                                AppLocalization.of(context)!
                                    .getTranslatedValues('resetPwdLbl')!,
                                style: TextStyle(
                                    fontSize: 24,
                                    color: Theme.of(context).primaryColor,
                                    fontWeight: FontWeight.bold),
                              ),
                              Padding(
                                  padding: EdgeInsetsDirectional.only(
                                      start: 20, end: 20, top: 20),
                                  child: Text(
                                    AppLocalization.of(context)!
                                        .getTranslatedValues(
                                            'resetEnterEmailLbl')!,
                                    textAlign: TextAlign.center,
                                    style: TextStyle(
                                        fontSize: 18,
                                        color: Theme.of(context).primaryColor,
                                        fontWeight: FontWeight.w600),
                                  )),
                              Padding(
                                  padding: EdgeInsetsDirectional.only(
                                      start: MediaQuery.of(context).size.width *
                                          .08,
                                      end: MediaQuery.of(context).size.width *
                                          .08,
                                      top: 20),
                                  child: showEmailForForgotPwd()),
                              SizedBox(
                                height: 30,
                              ),
                              CustomRoundedButton(
                                  widthPercentage: 0.55,
                                  backgroundColor:
                                      Theme.of(context).primaryColor,
                                  buttonTitle: AppLocalization.of(context)!
                                      .getTranslatedValues('submitBtn')!,
                                  radius: 10,
                                  showBorder: false,
                                  height: 50,
                                  onTap: () {
                                    final form = _formKeyDialog.currentState;
                                    if (form!.validate()) {
                                      form.save();
                                      UiUtils.setSnackbar(
                                          AppLocalization.of(context)!
                                              .getTranslatedValues(
                                                  'pwdResetLinkLbl')!,
                                          context,
                                          false);
                                      AuthRemoteDataSource().resetPassword(
                                          edtEmailReset.text.trim());
                                      Future.delayed(const Duration(seconds: 1),
                                          () {
                                        Navigator.pop(context, 'Cancel');
                                      });
                                    }
                                  })
                            ],
                          ),
                        ),
                      )));
            }),
      ),
    );
  }

  Widget orLabel() {
    return Container(
        margin: EdgeInsets.symmetric(vertical: 10),
        child: Text(
          AppLocalization.of(context)!.getTranslatedValues('orLbl')!,
          style: Theme.of(context)
              .textTheme
              .subtitle1!
              .copyWith(color: Theme.of(context).primaryColor),
        ));
  }

  Widget loginWith() {
    return Container(
        child: Text(
      AppLocalization.of(context)!.getTranslatedValues('loginSocialMediaLbl')!,
      textAlign: TextAlign.center,
      style: TextStyle(
          fontWeight: FontWeight.w300,
          color: Theme.of(context).primaryColor,
          fontSize: 14),
    ));
  }

  Widget showSocialMedia(BuildContext context) {
    return BlocConsumer<SignInCubit, SignInState>(
      listener: (context, state) {
        //Exceuting only if authProvider is not email
        if (state is SignInSuccess &&
            state.authProvider != AuthProvider.email) {
          context.read<AuthCubit>().updateAuthDetails(
              authProvider: state.authProvider,
              firebaseId: state.user.uid,
              authStatus: true,
              isNewUser: state.isNewUser);
          if (state.isNewUser) {
            context.read<UserDetailsCubit>().fetchUserDetails(state.user.uid);
            //navigate to select profile screen
            Navigator.of(context)
                .pushReplacementNamed(Routes.selectProfile, arguments: true);
          } else {
            //get user detials of signed in user
            context.read<UserDetailsCubit>().fetchUserDetails(state.user.uid);
            //updateFcm id
            print(state.user.uid);
            Navigator.of(context)
                .pushReplacementNamed(Routes.home, arguments: false);
          }
        } else if (state is SignInFailure &&
            state.authProvider != AuthProvider.email) {
          UiUtils.setSnackbar(
              AppLocalization.of(context)!.getTranslatedValues(
                  convertErrorCodeToLanguageKey(state.errorMessage))!,
              context,
              false);
        }
      },
      builder: (context, state) {
        if (state is SignInProgress &&
            state.authProvider != AuthProvider.email) {
          return Center(
              child: CircularProgressContainer(
            useWhiteLoader: false,
          ));
        }
        return Container(
          padding: EdgeInsets.only(
            top: state is SignInProgress ? 30.0 : 20,
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              kIsWeb || Platform.isAndroid
                  ? InkWell(
                      child: SvgPicture.asset(
                        'assets/images/google_icon.svg',
                        height: MediaQuery.of(context).size.height * .07,
                        width: MediaQuery.of(context).size.width * .1,
                      ),
                      onTap: () async {
                        context
                            .read<SignInCubit>()
                            .signInUser(AuthProvider.gmail);
                      },
                    )
                  : InkWell(
                      child: SvgPicture.asset(
                        'assets/images/appleicon.svg',
                        height: MediaQuery.of(context).size.height * .07,
                        width: MediaQuery.of(context).size.width * .1,
                      ),
                      onTap: () async {
                        context
                            .read<SignInCubit>()
                            .signInUser(AuthProvider.apple);
                        // context.read<SignInCubit>().signInUser(AuthProvider.fb);
                      },
                    ),
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 20.0),
                child: InkWell(
                  child: SvgPicture.asset(
                    'assets/images/facebook_icon.svg',
                    height: MediaQuery.of(context).size.height * .07,
                    width: MediaQuery.of(context).size.width * .1,
                  ),
                  onTap: () async {
                    context.read<SignInCubit>().signInUser(AuthProvider.fb);
                    // context.read<SignInCubit>().signInUser(AuthProvider.gmail);
                  },
                ),
              ),
              InkWell(
                child: SvgPicture.asset(
                  'assets/images/phone_icon.svg',
                  height: MediaQuery.of(context).size.height * .07,
                  width: MediaQuery.of(context).size.width * .1,
                ),
                onTap: () {
                  Navigator.of(context).pushNamed(Routes.otpScreen);
                },
              ),
            ],
          ),
        );
      },
    );
  }

  Widget showGoSignup() {
    return Container(
      child: Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Text(
            AppLocalization.of(context)!.getTranslatedValues('noAccountLbl')!,
            style: TextStyle(
              fontSize: 14,
              color: Theme.of(context).colorScheme.secondary.withOpacity(0.5),
            ),
          ),
          SizedBox(width: 4),
          CupertinoButton(
            onPressed: () {
              Navigator.of(context).pushNamed(Routes.signUp);
            },
            padding: EdgeInsets.all(0),
            child: Text(
              AppLocalization.of(context)!.getTranslatedValues('signUpLbl')!,
              style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w700,
                  color: Theme.of(context).primaryColor),
            ),
          ),
        ],
      ),
    );
  }
}
