<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\User;
use common\models\UserRefreshToken;

/**
 * Site controller
 */
class AuthController extends BaseController
{

    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }

    private function generateJwt(User $user) {
		$jwt = Yii::$app->jwt;
		$signer = $jwt->getSigner('HS256');
		$key = $jwt->getKey();
		$time = time();

		$jwtParams = Yii::$app->params['jwt'];

		return  $jwt->getBuilder()
			->issuedBy($jwtParams['issuer'])
			->permittedFor($jwtParams['audience'])
			->identifiedBy($jwtParams['id'], true)
			->issuedAt($time)
			->expiresAt($time + $jwtParams['expire'])
			->withClaim('uid', $user->id)
			->getToken($signer, $key);
	}

	/**
	 * @throws yii\base\Exception
	 */
	private function generateRefreshToken(User $user, User $impersonator = null): UserRefreshToken {
		$refreshToken = Yii::$app->security->generateRandomString(200);

		// TODO: Don't always regenerate - you could reuse existing one if user already has one with same IP and user agent
		$userRefreshToken = new UserRefreshToken([
			'urf_userID' => $user->id,
			'urf_token' => $refreshToken,
			'urf_ip' => Yii::$app->request->userIP,
			'urf_user_agent' => Yii::$app->request->userAgent,
			'urf_created' => gmdate('Y-m-d H:i:s'),
		]);
		if (!$userRefreshToken->save()) {
			throw new \yii\web\ServerErrorHttpException('Failed to save the refresh token: '. $userRefreshToken->getErrorSummary(true));
		}

		// Send the refresh-token to the user in a HttpOnly cookie that Javascript can never read and that's limited by path
		Yii::$app->response->cookies->add(new \yii\web\Cookie([
			'name' => 'refresh-token',
			'value' => $refreshToken,
			'httpOnly' => true,
			'sameSite' => 'none',
			'secure' => true,
			'path' => '/v1/auth/refresh-token',  //endpoint URI for renewing the JWT token using this refresh-token, or deleting refresh-token
		]));

		return $userRefreshToken;
	}

    public function actionLogin() {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$model = new LoginForm();
        if ($model->load(Yii::$app->request->post() , '') && $model->login()) {
            // if($model->login()){
            // die('asd');
			$user = Yii::$app->user->identity;

			$token = $this->generateJwt($user);
			// print_r($token); die('asdasdasdasd');

			$this->generateRefreshToken($user);
			// \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			return $this->asJson([
				'user' => $user,
				'token' => (string) $token,
			]);
		} else {
			return $model->getFirstErrors();
		}
	}

	public function actionCreate()
	{
		$model = new SignupForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->signup()) {
            return $this->asJson([
				'status' => true,
				'model' => $model
			]);
        }
		
		// print_r($model); die;

		

		return $this->asJson([
			'status' => false,
			'errors' => $model->errors
		]);

        
	}
   
}
