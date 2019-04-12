package com.ExodiaSolutions.sunnynarang.itmexodia;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.amulyakhare.textdrawable.TextDrawable;

import java.io.BufferedReader;
import java.io.BufferedWriter;
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

public class ViewAttendanceTeacherLv extends AppCompatActivity {
   private String roll_teacher,classes,sem,course,class_id,sub_id,branch,subject,batch;
    private  static String[] color = {"9c000000","FF7043", "8D6E63", "26A69A", "7E57C2", "42A5F5", "29B6F6", "26A69A", "FF7043", "BDBDBD", "78909C"};
    private CustomAdapter3 adapter;
    private ListView listview;
    ProgressDialog pd;
    private ArrayList<ViewAttendanceTeacherFormator> arraylist= new ArrayList<>();

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
               ViewAttendanceTeacherLv.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_attendance_teacher_lv);
       
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("Attendance");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);
        
        roll_teacher = getIntent().getStringExtra("roll_teacher");
        //Toast.makeText(this, ""+roll_teacher, Toast.LENGTH_SHORT).show();
        classes= getIntent().getStringExtra("class_select");
        sem= getIntent().getStringExtra("sem_select");
        course= getIntent().getStringExtra("course_select");
        class_id= getIntent().getStringExtra("class_id");
        sub_id= getIntent().getStringExtra("subject_id");
        branch= getIntent().getStringExtra("branch_select");
        subject= getIntent().getStringExtra("subject_select");
        batch= getIntent().getStringExtra("batch");
        adapter = new CustomAdapter3(this,arraylist);
        listview = (ListView) findViewById(R.id.viewAttendanceTeacher_lv);
        listview.setAdapter(adapter);
        adapter.notifyDataSetChanged();

        final AttendanceLoader attendanceLoader = new AttendanceLoader(this);
        attendanceLoader.execute();

        Handler handler = new Handler();
        handler.postDelayed(new Runnable()
        {
            @Override
            public void run() {
                if ( attendanceLoader.getStatus() == AsyncTask.Status.RUNNING )
                {attendanceLoader.cancel(true);
                    Toast.makeText(ViewAttendanceTeacherLv.this, "Time OUT", Toast.LENGTH_SHORT).show();
                    if(pd.isIndeterminate())
                    pd.dismiss();
                }
            }
        }, 20000 );
       // Toast.makeText(this, " hjkhij "+roll_teacher+"  "+class_id+"  asddf  "+sub_id+" ghjj ", Toast.LENGTH_SHORT).show();
    }

    class CustomAdapter3 extends ArrayAdapter<ViewAttendanceTeacherFormator> {
        Context c;
        public CustomAdapter3(Context context, ArrayList<ViewAttendanceTeacherFormator> arrayList) {
            super(context, R.layout.view_attendance_teacher_card, arrayList);
            this.c = context;
        }


        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {
            
            
         
                ViewAttendanceTeacherFormator data = getItem(pos);
                LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
                convertView = li.inflate(R.layout.view_attendance_teacher_card, parent, false);

                TextView name = (TextView) convertView.findViewById(R.id.tcr_att_name);
                TextView roll = (TextView) convertView.findViewById(R.id.tcr_lv_roll);
                TextView attended = (TextView) convertView.findViewById(R.id.tcr_att_attended);
                TextView out_of = (TextView) convertView.findViewById(R.id.tcr_att_outof);
                     name.setText(data.getName());
                     roll.setText(data.getRoll());
                     attended.setText(data.getAttended());
                     out_of.setText(data.getOut_of());
                ImageView imageView = (ImageView) convertView.findViewById(R.id.tcr_att_image);
                int col=pos;
                if(pos>=10){
                    col=pos%10;
                }
                TextDrawable drawable = TextDrawable.builder()
                        .buildRound(data.getName().toUpperCase().charAt(0)+"", Color.parseColor("#"+color[col]));
                imageView.setImageDrawable(drawable);

            return convertView;

        }
    }


    public class AttendanceLoader extends AsyncTask<Void, Void, String> {

        Context context;
        AlertDialog alertdialog;

        AttendanceLoader(Context context) {
            this.context = context;
        }


        @Override
        protected String doInBackground(Void... params) {


            String login_url = "https://exodia-incredible100rav.c9users.io/android/php/getclasswiseatt.php";

            try {

                URL url = new URL(login_url);
                HttpURLConnection httpurlconnection = (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("roll", "UTF-8") + "=" + URLEncoder.encode(roll_teacher, "UTF-8")+ "&"
                        + URLEncoder.encode("class_id", "UTF-8") + "=" + URLEncoder.encode(class_id, "UTF-8")+ "&"
                        + URLEncoder.encode("sub_id", "UTF-8") + "=" + URLEncoder.encode(sub_id, "UTF-8");
                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();

                InputStream inputstream = httpurlconnection.getInputStream();
                BufferedReader bufferedreader = new BufferedReader(new InputStreamReader(inputstream, "iso-8859-1"));
                String result = "";
                String line = "";
                while ((line = bufferedreader.readLine()) != null) {
                    result += line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return "";
        }


        @Override
        protected void onPreExecute() {
           // Toast.makeText(context, roll_teacher+"  " + sub_id+"   " +class_id+" ", Toast.LENGTH_SHORT).show();
                pd = new ProgressDialog(ViewAttendanceTeacherLv.this);
                pd.setTitle("Loading.");
                pd.setMessage("Please wait...\nLoading Subjects.");
                pd.setCancelable(false);
                pd.show();

            alertdialog = new AlertDialog.Builder(context).create();
            alertdialog.setTitle("Login Status");
        }

        @Override
        protected void onPostExecute(String result) {
            pd.dismiss();
          //  Toast.makeText(context, ""+result, Toast.LENGTH_SHORT).show();

            if(!result.equalsIgnoreCase("")){

                arraylist.addAll(ViewAttendanceTeacherFormator.jsonToArraylist(result,batch));
                adapter.notifyDataSetChanged();
            }

        }
    }

}
