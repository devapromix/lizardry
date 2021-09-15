object FormMain: TFormMain
  Left = 0
  Top = 0
  Caption = 'Lizardry'
  ClientHeight = 712
  ClientWidth = 1184
  Color = clBtnFace
  Constraints.MinHeight = 750
  Constraints.MinWidth = 1200
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  WindowState = wsMaximized
  OnCreate = FormCreate
  OnShow = FormShow
  PixelsPerInch = 96
  TextHeight = 13
  inline FrameLogin: TFrameLogin
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 0
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 712
      inherited CurrentClientVersion: TLabel
        Top = 696
      end
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 712
      ExplicitWidth = 934
      ExplicitHeight = 712
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 734
          ExplicitHeight = 487
        end
      end
      inherited Panel4: TPanel
        Width = 934
        Height = 487
        ExplicitWidth = 934
        ExplicitHeight = 487
      end
    end
  end
  inline FrameRegistration: TFrameRegistration
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 1
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 712
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 712
      ExplicitLeft = 250
      ExplicitTop = 0
      ExplicitWidth = 934
      ExplicitHeight = 712
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 734
          ExplicitHeight = 487
        end
      end
      inherited Panel4: TPanel
        Width = 934
        Height = 487
        ExplicitWidth = 934
        ExplicitHeight = 487
      end
    end
  end
  inline FrameTown: TFrameTown
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 2
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited Panel7: TPanel
      Left = 904
      Height = 712
      ExplicitLeft = 904
      ExplicitHeight = 712
    end
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 712
    end
    inherited Panel9: TPanel
      Width = 624
      Height = 712
      ExplicitWidth = 624
      ExplicitHeight = 712
      inherited Panel10: TPanel
        Width = 624
        ExplicitWidth = 624
      end
      inherited FramePanel: TPanel
        Top = 512
        Width = 624
        ExplicitTop = 512
        ExplicitWidth = 624
        inherited FrameBank1: TFrameBank
          Width = 622
          ExplicitWidth = 622
        end
        inherited FrameDefault1: TFrameDefault
          Width = 622
          ExplicitWidth = 622
        end
        inherited FrameTavern1: TFrameTavern
          Width = 622
          ExplicitWidth = 622
        end
        inherited FrameOutlands1: TFrameOutlands
          Width = 622
          ExplicitWidth = 622
        end
      end
      inherited Panel19: TPanel
        Width = 624
        Height = 487
        ExplicitWidth = 624
        ExplicitHeight = 487
        inherited FrameInfo1: TFrameInfo
          Width = 622
          Height = 485
          ExplicitWidth = 622
          ExplicitHeight = 485
          inherited StaticText2: TStaticText
            Top = 351
            Width = 622
            ExplicitTop = 351
            ExplicitWidth = 622
          end
          inherited StaticText1: TStaticText
            Width = 622
            Height = 351
            ExplicitWidth = 622
            ExplicitHeight = 351
          end
        end
        inherited FrameLoot1: TFrameLoot
          Width = 622
          Height = 485
          ExplicitWidth = 622
          ExplicitHeight = 485
        end
        inherited FrameBattle1: TFrameBattle
          Width = 622
          Height = 485
          ExplicitWidth = 622
          ExplicitHeight = 485
          inherited Panel1: TPanel
            Width = 622
            Height = 348
            ExplicitWidth = 622
            ExplicitHeight = 348
            inherited RichEdit1: TRichEdit
              Width = 620
              Height = 346
              ExplicitWidth = 620
              ExplicitHeight = 346
            end
          end
          inherited Panel2: TPanel
            Width = 622
            ExplicitWidth = 622
            inherited Panel3: TPanel
              Left = 284
              ExplicitLeft = 284
            end
          end
        end
      end
    end
  end
end
