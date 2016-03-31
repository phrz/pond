<?php
// Routes
use Illuminate\Database\Eloquent\ModelNotFoundException;

$app->post('/api/auth', function ($req, $res, $args) {
    $auth = new \Pond\Auth($this);
    return $auth->loginHandler($req, $res);
});

$app->get('/api/auth/{user_id}', function ($req, $res) {
    $auth = new \Pond\Auth($this);
    $uid = $req->getAttribute('user_id');
    $isAuth = $auth->isRequestAuthorized($req,$uid);
    return $isAuth ? $res->withStatus(200) : $res->withStatus(401);
});

$app->get('/api/lessons/{lesson_id}', function($req, $res, $args) {
    try{
        $lessons = Pond\Lesson::findOrFail($args['lesson_id']);
        $stat = new \Pond\StatusContainer($lessons);
        $stat->success();
        $stat->message("Here is the requested lesson");
        return $res->withJson($stat);
    }
    catch(ModelNotFoundException $e){
        $stat = new \Pond\StatusContainer($lessons);
        $stat->error("Lesson Not Found");
        $stat->message('Lesson not found.');
        $res = $res->withStatus(404);
        return $res->withJson($stat);
    }
});

/*$app->put('/api/lessons/{lesson_id}', function($req, $res, $args) {
    $auth = new \Pond\Auth($this);
    try{
        $lessons = Pond\Lesson::findOrFail($args['lesson_id']);
        $creator_id = $lessons->creator_id;
        $isAuth = $auth->isRequestAuthorized($req,$creator_id);
        if(!$isAuth) {
            $res->withStatus(401); // Unauthorized
        } else {
            $stat = new \Pond\StatusContainer($lessons);
            $stat->success();
            $lessons->delete();
            $stat->message("The lesson has been deleted");
            return $res->withJson($stat);
        }

    }
    catch(ModelNotFoundException $e){
        $stat = new \Pond\StatusContainer($lessons);
        $stat->error("Lesson Not Found");
        $stat->message('Lesson not found.');
        $res = $res->withStatus(404);
        return $res->withJson($stat);
    }
});

$app->delete('/api/lessons/{lesson_id}', function($req, $res, $args) {
    $auth = new \Pond\Auth($this);
    try{
        $lessons = Pond\Lesson::findOrFail($args['lesson_id']);
        $creator_id = $lessons->creator_id;
        $isAuth = $auth->isRequestAuthorized($req,$creator_id);
        if(!$isAuth) {
            $res->withStatus(401); // Unauthorized
        } else {
            $stat = new \Pond\StatusContainer($lessons);
            $stat->success();
            $lessons->delete();
            $stat->message("The lesson has been deleted");
            return $res->withJson($stat);
        }

    }
    catch(ModelNotFoundException $e){
        $stat = new \Pond\StatusContainer($lessons);
        $stat->error("Lesson Not Found");
        $stat->message('Lesson not found.');
        $res = $res->withStatus(404);
        return $res->withJson($stat);
    }
});*/

$app->get('/api/lessons', function($req, $res, $args) {

  $lessonObj = [];
  $lessons = \Pond\Lesson::all();

  foreach($lessons as $lesson){
    array_push($lessonObj, $lesson->toArray());
  }

  $stat = new \Pond\StatusContainer($lessonObj);
  $stat->success();
  $stat->message("Here are the lessons");
  $res = $res->withStatus(200);
  return $res->withJson($stat);
});

$app->post('/api/lessons', function($req, $res, $args) {
  $lesson = new \Pond\Lesson();
  $form = $req->getParsedBody();

  $lesson->creator_id = @$form['creator_id'];
  $lesson->lesson_name = @$form['lesson_name'];
  $lesson->save();
  $stat = new \Pond\StatusContainer($lesson);
  $stat->success();
  $stat->message("Lesson created");
  $res = $res->withStatus(200);
  return $res->withJson($stat);

});
