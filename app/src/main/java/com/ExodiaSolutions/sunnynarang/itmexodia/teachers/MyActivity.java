package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.LinearLayoutManager;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.Link;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;
import com.facebook.drawee.backends.pipeline.Fresco;
import com.facebook.drawee.view.SimpleDraweeView;
import com.lorentzos.flingswipe.SwipeFlingAdapterView;

import org.apache.commons.io.FileUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;

import butterknife.ButterKnife;
import butterknife.InjectView;
import butterknife.OnClick;


public class MyActivity extends Activity {

    private ArrayList<String> al;
    private ArrayAdapter<String> arrayAdapter;
    private int i=0;
    JSONArray jsonArray;
    CustomAdapter3 custom;
    ProgressDialog pd;
    Button b1;
    Button b2;
    String period,time,batch_select,course_select,sem_select,class_select,branch_select,roll_teacher,name_teacher,subject_select,class_id,subject_id,timestamp,tid;
    String br_id,c_id,section_id;
    String offline_student_list="";
    ArrayList<Student> arraylist = new ArrayList<>();
    ArrayList<Student> temp_arraylist = new ArrayList<>();
    @InjectView(R.id.frame) SwipeFlingAdapterView flingContainer;
    boolean doubleBackToExitPressedOnce = false;

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                MyActivity.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public void onBackPressed() {
        if (doubleBackToExitPressedOnce) {
            super.onBackPressed();
            return;
        }

        this.doubleBackToExitPressedOnce = true;
        Toast.makeText(this, "Please tap BACK again to exit", Toast.LENGTH_SHORT).show();

        new Handler().postDelayed(new Runnable() {

            @Override
            public void run() {
                doubleBackToExitPressedOnce=false;
            }
        }, 2000);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Fresco.initialize(MyActivity.this);
        setContentView(R.layout.activity_my);
        ButterKnife.inject(this);

        course_select=getIntent().getStringExtra("course_select");
        sem_select=getIntent().getStringExtra("sem_select");
        class_select=getIntent().getStringExtra("class_select");
        branch_select=getIntent().getStringExtra("branch_select");
        roll_teacher=getIntent().getStringExtra("roll_teacher");
        name_teacher=getIntent().getStringExtra("name_teacher");
        subject_select = getIntent().getStringExtra("subject_select");
        subject_id = getIntent().getStringExtra("subject_id");
        class_id = getIntent().getStringExtra("class_id");
        timestamp = getIntent().getStringExtra("timestamp");
        batch_select = getIntent().getStringExtra("batch");
        time = getIntent().getStringExtra("time");
        c_id = getIntent().getStringExtra("c_id");
        br_id = getIntent().getStringExtra("br_id");
        section_id = getIntent().getStringExtra("section_id");
        period= getIntent().getStringExtra("period");
        tid= getIntent().getStringExtra("tid");

       // Toast.makeText(this, ""+batch_select, Toast.LENGTH_SHORT).show();
        TextView strip1 = (TextView) findViewById(R.id.swipe_strip1);
        TextView strip2 = (TextView) findViewById(R.id.swipe_strip2);

        b1 = (Button) findViewById(R.id.right);
        b2 = (Button) findViewById(R.id.left);

        strip1.setText(course_select+" | "+branch_select+" | "+class_select);

        strip2.setText("SEM-"+sem_select+" | "+subject_select);
        readItems();

        final ClassLoader classLoader = new ClassLoader();
        if(offline_student_list.equalsIgnoreCase("0")){
        if (isNetworkAvailable()){
            classLoader.execute();
            Handler handler = new Handler();
            handler.postDelayed(new Runnable()
            {
                @Override
                public void run() {
                    if ( classLoader.getStatus() == AsyncTask.Status.RUNNING )
                    {classLoader.cancel(true);
                        Toast.makeText(MyActivity.this, "Time OUT", Toast.LENGTH_SHORT).show();
                        if(pd.isIndeterminate())
                        pd.dismiss();
                    }
                }
            }, 20000 );
        }
        else
        {
            Toast.makeText(this, "No Data Found\nPlease Connect To Internet", Toast.LENGTH_SHORT).show();
        MyActivity.this.finish();
        }}
        else if(!offline_student_list.equalsIgnoreCase("")){

            try {
                i=0;
                jsonArray = new JSONArray(offline_student_list);
                for(int no=0;no<jsonArray.length();no++) {
                    JSONObject jsonObject = jsonArray.optJSONObject(no);
                    String readed_name = jsonObject.getString("name");
                    String readed_roll = jsonObject.getString("rollno");
                        String readed_img = jsonObject.getString("rollno");
                        Student stu = new Student(readed_img,readed_roll,readed_name);
                    arraylist.add(stu);

                }
                //https://exodia-incredible100rav.c9users.io/android/test_img/1.jpg

            } catch (JSONException e) {
                e.printStackTrace();
            }

            custom = new CustomAdapter3(MyActivity.this,arraylist);
            flingContainer.setAdapter(custom);
            custom.notifyDataSetChanged();
            flingContainer.setFlingListener(new SwipeFlingAdapterView.onFlingListener() {
                @Override
                public void removeFirstObjectInAdapter() {
                    // this is the simplest way to delete an object from the Adapter (/AdapterView)
                    //Log.d("LIST", "removed object!");
                    if(!arraylist.isEmpty())
                    arraylist.remove(0);
                    i++;
                    custom.notifyDataSetChanged();}


                @Override
                public void onLeftCardExit(Object dataObject) {
                    //Do something on the left!
                    //You also have access to the original object.
                    //If you want to use it just cast it (String) dataObject

                    Student s = (Student) dataObject;
                    s.setStatus(0);
                    temp_arraylist.add(s);
                    b2.setPressed(true);
                    b2.setPressed(false);
                }
                    //makeToast(MyActivity.this, s.getName()+" Absent");


                @Override
                public void onRightCardExit(Object dataObject) {
                 Student s = (Student) dataObject;
                    s.setStatus(1);
                    temp_arraylist.add(s);
                    b1.setPressed(true);
                    b1.setPressed(false);
                }
                    // makeToast(MyActivity.this, s.getName()+" Present");
                @Override
                public void onAdapterAboutToEmpty(int itemsInAdapter) {
                    if(itemsInAdapter==0){
                        b1.setEnabled(false);
                        b2.setEnabled(false);
                        upload();}
                    // Ask for more data here
                    // Toast.makeText(MyActivity.this, "DONE", Toast.LENGTH_SHORT).show();
                    // al.add("XML ".concat(String.valueOf(i)));
                    //   arrayAdapter.notifyDataSetChanged();
                    Log.d("LIST", "notified");
                    i++;
                }

                @Override
                public void onScroll(float scrollProgressPercent) {
                    View view = flingContainer.getSelectedView();
//                view.findViewById(R.id.item_swipe_right_indicator).setAlpha(scrollProgressPercent < 0 ? -scrollProgressPercent : 0);
                    //              view.findViewById(R.id.item_swipe_left_indicator).setAlpha(scrollProgressPercent > 0 ? scrollProgressPercent : 0);
                }
            });


        }else {
            if (isNetworkAvailable()) {
               // Toast.makeText(this, " "+course_select+" "+class_select+" "+sem_select+" "+branch_select, Toast.LENGTH_SHORT).show();
                classLoader.execute();
            }else
            {
                Toast.makeText(MyActivity.this, "No Data Found\nPlease Connect To Internet", Toast.LENGTH_SHORT).show();
                MyActivity.this.finish();
            }
        }



        // Optionally add an OnItemClickListener
        flingContainer.setOnItemClickListener(new SwipeFlingAdapterView.OnItemClickListener() {
            @Override
            public void onItemClicked(int itemPosition, Object dataObject) {
               // makeToast(MyActivity.this, "Clicked!");
            }
        });

    }

    static void makeToast(Context ctx, String s){
        Toast.makeText(ctx, s, Toast.LENGTH_SHORT).show();
    }


    @OnClick(R.id.right)
    public void right() {
        /**
         * Trigger the right event manually.
         */
        flingContainer.getTopCardListener().selectRight();
    }

    @OnClick(R.id.left)
    public void left() {
        flingContainer.getTopCardListener().selectLeft();
    }

    class CustomAdapter3 extends ArrayAdapter<Student> {
        Context c;

        public CustomAdapter3(Context context, ArrayList<Student> arrayList) {
            super(context, R.layout.student_card, arrayList);
            this.c = context;
        }


        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {

            LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
            convertView = li.inflate(R.layout.student_card, parent, false);

            Student sub_class1 = getItem(pos);

            TextView sub_name = (TextView) convertView.findViewById(R.id.student_name);
            TextView sub_roll = (TextView) convertView.findViewById(R.id.student_roll);
            sub_roll.setText(sub_class1.getRoll());

           Uri imageUri = Uri.parse("http://mis.itmuniversity.ac.in/itmzone/StudentPhoto/"+sub_class1.getRoll()+".jpeg");
            SimpleDraweeView draweeView = (SimpleDraweeView) convertView.findViewById(R.id.sdvImage);
            draweeView.setImageURI(imageUri);

//            Toast.makeText(MyActivity.this, ""+sub_class1.getImage(), Toast.LENGTH_SHORT).show();
            sub_name.setText(sub_class1.getName());
            return convertView;

        }
    }
    public class ClassLoader extends AsyncTask<String, Void, String>
    {
        String res;

        @Override
        protected String doInBackground(String... params) {



            String login_url = null;
            if( Link.getInstance().getHashMapLink().containsKey("get_student_att_list")){
                login_url = Link.getInstance().getHashMapLink().get("get_student_att_list");
            }

            try {
                URL url = new URL(login_url);
                HttpURLConnection httpurlconnection = (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestProperty("Accept","text/html");
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("CourseType", "UTF-8") + "=" + URLEncoder.encode(c_id, "UTF-8")+ "&"
                        + URLEncoder.encode("BranchType", "UTF-8") + "=" + URLEncoder.encode(br_id, "UTF-8")+ "&"
                        + URLEncoder.encode("Section", "UTF-8") + "=" + URLEncoder.encode(section_id, "UTF-8");
                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();


                InputStream inputstream = httpurlconnection.getInputStream();
                BufferedReader bufferedreader = new BufferedReader(new InputStreamReader(inputstream, "iso-8859-1"));
                res = "";
                String line = "";
                while ((line = bufferedreader.readLine()) != null) {
                    res += line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();
                return res;
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }


            return null;
        }

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
           pd = new ProgressDialog(MyActivity.this);
            pd.setTitle("Loading.");
            pd.setMessage("Please wait... \nLoading Student List.");
            pd.setCancelable(false);
            pd.show();

        }

        @Override
        protected void onPostExecute(String s) {
            //Toast.makeText(MyActivity.this,s,Toast.LENGTH_LONG).show();
            if(!s.equalsIgnoreCase(null)) {
                if (s.equalsIgnoreCase("0")) {
                    Toast.makeText(MyActivity.this, "No Student List Found", Toast.LENGTH_SHORT).show();
                    MyActivity.this.finish();
                }
                pd.dismiss();
                writeItems(s);
                arraylist.clear();
                try {
                    i = 0;
                    jsonArray = new JSONArray(s);
                    for (int no = 0; no < jsonArray.length(); no++) {
                        JSONObject jsonObject = jsonArray.optJSONObject(no);
                            String readed_name = jsonObject.getString("name");
                            String readed_roll = jsonObject.getString("rollno");
                            String readed_img = "ram.jpg";//jsonObject.getString("image");
                            Student stu = new Student(readed_img,readed_roll,readed_name);
                            arraylist.add(stu);
                    }
                    //https://exodia-incredible100rav.c9users.io/android/test_img/1.jpg

                } catch (JSONException e) {
                    e.printStackTrace();
                }
                custom = new CustomAdapter3(MyActivity.this, arraylist);

                custom.notifyDataSetChanged();
                flingContainer.setAdapter(custom);
                if (!s.equalsIgnoreCase("")&&!s.equalsIgnoreCase("0")) {
                    finish();
                    startActivity(getIntent());
                }
            }

        }

    }

    public void upload()
    {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setMessage("    Attendance Taken")
                .setCancelable(false)
                .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        Intent i = new Intent(MyActivity.this,EditAttendance.class);
                        i.putExtra("data", temp_arraylist);
                        i.putExtra("roll_teacher",roll_teacher);
                        i.putExtra("name_teacher",name_teacher);
                        i.putExtra("class_select",class_select);
                        i.putExtra("sem_select",sem_select);
                        i.putExtra("course_select",course_select);
                        i.putExtra("branch_select",branch_select);
                        i.putExtra("subject_select",subject_select);
                        i.putExtra("class_id",class_id);
                        i.putExtra("subject_id",subject_select);
                        i.putExtra("timestamp",timestamp);
                        i.putExtra("time",time);
                        i.putExtra("c_id",c_id);
                        i.putExtra("br_id",br_id);
                        i.putExtra("section_id",section_id);
                        i.putExtra("period",period);
                        i.putExtra("tid",tid);
                        i.putExtra("batch",batch_select);
                        MyActivity.this.finish();
                        startActivity(i);
                        //AttendanceUpload attendanceUpload=new AttendanceUpload();
                        //attendanceUpload.execute();

                    }
                });
        AlertDialog alert = builder.create();
        alert.show();

    }

    private void writeItems(String s) {

        File filesDir = getFilesDir();
        File todoFile = new File(filesDir, c_id+"_"+br_id+"_"+section_id+".txt");
        try {


            FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private void readItems()  {

        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,c_id+"_"+br_id+"_"+section_id+".txt");
        try {
            offline_student_list = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
            offline_student_list = "";
        }
    }
    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }

    public void refresh_std_list(View v)
    {
        if (isNetworkAvailable()) {

            ClassLoader classLoader = new ClassLoader();
            classLoader.execute();



        }else
        {
            Toast.makeText(MyActivity.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();

        }
    }

    public void skip_to_edit(View v){
        for(int i=0;i<arraylist.size();i++) {
            Student s = arraylist.get(i);
            s.setStatus(0);
            temp_arraylist.add(s);

        }
        upload();
    }

}

